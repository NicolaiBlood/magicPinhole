// Order intake endpoint for the magicPinhole site.
// Deployed on Deno Deploy (project root dir: api/).
//
// Env vars:
//   ALLOWED_ORIGINS - comma-separated list of allowed site origins
//   EXPORT_TOKEN    - secret token required by GET /orders
//   PORT            - optional, defaults to 8000

const ORIGINS = (Deno.env.get("ALLOWED_ORIGINS") ?? "")
  .split(",")
  .map((o) => o.trim().replace(/\/+$/, ""))
  .filter(Boolean);
const EXPORT_TOKEN = Deno.env.get("EXPORT_TOKEN") ?? "";

const MAX_LENGTHS: Record<string, number> = {
  name: 100,
  email: 254,
  street: 200,
  apt: 30,
  city: 100,
  state: 100,
  zip: 20,
};

const RATE_LIMIT = 5;
const RATE_WINDOW_MS = 3600_000;

type Order = {
  date: string;
  name: string;
  email: string;
  address: string;
};

const kv = await Deno.openKv();

function respond(
  status: number,
  ok: boolean,
  message: string,
  origin: string | null,
): Response {
  const headers = new Headers({
    "Content-Type": "application/json; charset=utf-8",
  });
  if (origin) headers.set("Access-Control-Allow-Origin", origin);
  return new Response(JSON.stringify({ ok, message }), { status, headers });
}

function clientIp(req: Request): string {
  return req.headers.get("x-forwarded-for")?.split(",")[0].trim() ?? "unknown";
}

async function overRateLimit(ip: string): Promise<boolean> {
  const key = ["rate", ip];
  const now = Date.now();
  const { value } = await kv.get<number[]>(key);
  const recent = (value ?? []).filter((t) => now - t < RATE_WINDOW_MS);
  if (recent.length >= RATE_LIMIT) return true;
  recent.push(now);
  await kv.set(key, recent, { expireIn: RATE_WINDOW_MS });
  return false;
}

function cleanField(form: FormData, key: string): string {
  const raw = form.get(key);
  const value = typeof raw === "string" ? raw : "";
  // Strips control characters except tab, newline, and carriage return,
  // matching the sanitization in the original PHP endpoint.
  // deno-lint-ignore no-control-regex
  return value.trim().replace(/[\x00-\x08\x0B\x0C\x0E-\x1F]/g, "");
}

function csvField(value: string): string {
  let v = value;
  if (v !== "" && "=+-@".includes(v[0])) v = "'" + v;
  if (/["\r\n,]/.test(v)) v = '"' + v.replaceAll('"', '""') + '"';
  return v;
}

async function handleOrder(req: Request, origin: string): Promise<Response> {
  if (await overRateLimit(clientIp(req))) {
    return respond(
      429,
      false,
      "Too many requests. Please try again in a little while.",
      origin,
    );
  }

  let form: FormData;
  try {
    form = await req.formData();
  } catch {
    return respond(400, false, "Please submit the website form.", origin);
  }

  // Honeypot: accept silently, store nothing.
  if (cleanField(form, "website") !== "") {
    return respond(200, true, "Thanks! Your order has been received.", origin);
  }

  const fields: Record<string, string> = {};
  for (const key of Object.keys(MAX_LENGTHS)) {
    fields[key] = cleanField(form, key);
    if (fields[key].length > MAX_LENGTHS[key]) {
      return respond(422, false, "One of the fields is too long.", origin);
    }
  }

  const { name, email, street, apt, city, state, zip } = fields;
  if (name === "" || street === "" || city === "" || zip === "") {
    return respond(
      422,
      false,
      "Please enter your name and shipping address.",
      origin,
    );
  }
  if (email !== "" && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    return respond(
      422,
      false,
      "Please check the email address you entered.",
      origin,
    );
  }

  let address = street + (apt !== "" ? ` Apt ${apt}` : "") + `, ${city}`;
  if (state !== "") address += `, ${state}`;
  address += ` ${zip}`;

  await kv.set(
    ["orders", Date.now()],
    {
      date: new Date().toISOString(),
      name,
      email,
      address,
    } satisfies Order,
  );

  return respond(
    200,
    true,
    "Thanks! Your spot on the order list is saved.",
    origin,
  );
}

async function handleOrders(req: Request): Promise<Response> {
  const auth = req.headers.get("Authorization") ?? "";
  const token = new URL(req.url).searchParams.get("token") ?? "";
  if (
    !EXPORT_TOKEN ||
    (auth !== `Bearer ${EXPORT_TOKEN}` && token !== EXPORT_TOKEN)
  ) {
    return new Response("Unauthorized", { status: 401 });
  }

  const rows: Order[] = [];
  for await (const entry of kv.list({ prefix: ["orders"] })) {
    rows.push(entry.value as Order);
  }
  rows.sort((a, b) => a.date.localeCompare(b.date));

  const lines = rows.map((r) =>
    [r.date, r.name, r.email, r.address].map(csvField).join(",")
  );
  const csv = ["date,name,email,address", ...lines].join("\n") + "\n";

  return new Response(csv, {
    headers: {
      "Content-Type": "text/csv; charset=utf-8",
      "Content-Disposition": 'attachment; filename="orders.csv"',
    },
  });
}

Deno.serve({ port: Number(Deno.env.get("PORT") ?? 8000) }, (req) => {
  const path = new URL(req.url).pathname;
  if (path === "/orders") return handleOrders(req);

  const origin = req.headers.get("Origin")?.replace(/\/+$/, "") ?? "";

  if (req.method === "OPTIONS") {
    if (!ORIGINS.includes(origin)) return new Response(null, { status: 403 });
    return new Response(null, {
      status: 204,
      headers: {
        "Access-Control-Allow-Origin": origin,
        "Access-Control-Allow-Methods": "POST, OPTIONS",
        "Access-Control-Allow-Headers": "Content-Type",
        "Access-Control-Max-Age": "86400",
      },
    });
  }

  if (!ORIGINS.includes(origin)) {
    return respond(
      403,
      false,
      "Orders are submitted through the website form.",
      null,
    );
  }

  if (path === "/order") return handleOrder(req, origin);
  return new Response("Not found", { status: 404 });
});

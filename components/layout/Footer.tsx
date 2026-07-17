import { eventData } from "@/data/event";

export default function Footer() {
  return (
    <footer
      id="contact"
      className="bg-neutral-950 border-t border-white/10 py-16"
    >
      <div className="mx-auto max-w-7xl px-6">

        <h2 className="text-3xl font-bold text-white">
          {eventData.title}
        </h2>

        <p className="mt-4 text-gray-400">
          {eventData.description}
        </p>

        <div className="mt-8 grid gap-6 md:grid-cols-3">

          <div>

            <h3 className="mb-3 text-yellow-400 font-semibold">
              Lokasi
            </h3>

            <p className="text-gray-300">
              {eventData.location}
            </p>

          </div>

          <div>

            <h3 className="mb-3 text-yellow-400 font-semibold">
              Kontak
            </h3>

            <p>{eventData.phone}</p>

            <p>{eventData.email}</p>

          </div>

          <div>

            <h3 className="mb-3 text-yellow-400 font-semibold">
              Sosial Media
            </h3>

            <p>{eventData.instagram}</p>

          </div>

        </div>

        <div className="mt-12 border-t border-white/10 pt-8 text-center text-gray-500">

          © 2026 TixEvent.
          All Rights Reserved.

        </div>

      </div>
    </footer>
  );
}
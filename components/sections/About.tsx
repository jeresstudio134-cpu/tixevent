export default function About() {
  return (
    <section
      id="about"
      className="bg-neutral-950 py-24"
    >
      <div className="mx-auto grid max-w-7xl gap-12 px-6 md:grid-cols-2">

        <div>

          <h2 className="mb-6 text-5xl font-bold text-white">
            Tentang Event
          </h2>

          <p className="text-lg leading-8 text-gray-300">
            Nusantara Music Festival merupakan festival musik tahunan
            yang menghadirkan artis nasional, panggung spektakuler,
            tata cahaya modern serta pengalaman konser terbaik.
          </p>

        </div>

        <div className="rounded-3xl bg-white/5 p-10">

          <h3 className="mb-6 text-2xl font-bold text-yellow-400">
            Informasi Event
          </h3>

          <div className="space-y-4 text-gray-300">

            <p>📅 18 Juni 2026</p>

            <p>📍 Gelora Bung Karno</p>

            <p>🕖 19.00 WIB</p>

            <p>🎵 15+ Guest Star</p>

          </div>

        </div>

      </div>
    </section>
  );
}
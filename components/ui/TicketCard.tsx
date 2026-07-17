import { Check } from "lucide-react";

type Props = {
  name: string;
  price: number;
  quota: number;
  description: string[];
};

export default function TicketCard({
  name,
  price,
  quota,
  description,
}: Props) {
  return (
    <div className="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur transition hover:scale-105 hover:border-yellow-500">

      <h2 className="mb-2 text-3xl font-bold text-white">
        {name}
      </h2>

      <p className="mb-6 text-4xl font-extrabold text-yellow-400">
        Rp {price.toLocaleString("id-ID")}
      </p>

      <div className="mb-6 text-sm text-gray-300">
        Kuota : {quota} Tiket
      </div>

      <ul className="mb-8 space-y-3">

        {description.map((item) => (
          <li
            key={item}
            className="flex items-center gap-2 text-gray-300"
          >
            <Check size={18} className="text-green-400" />
            {item}
          </li>
        ))}

      </ul>

      <button
        className="w-full rounded-xl bg-yellow-500 py-3 font-bold text-black transition hover:bg-yellow-400"
      >
        Pilih Tiket
      </button>

    </div>
  );
}
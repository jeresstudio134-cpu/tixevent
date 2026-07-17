import TicketCard from "@/components/ui/TicketCard";
import { tickets } from "@/data/tickets";

export default function TicketSection() {
  return (
    <section
      id="tickets"
      className="bg-black py-24"
    >
      <div className="mx-auto max-w-7xl px-6">

        <h2 className="mb-4 text-center text-5xl font-bold text-white">
          Pilihan Tiket
        </h2>

        <p className="mb-16 text-center text-gray-400">
          Pilih tiket sesuai kebutuhan Anda.
        </p>

        <div className="grid gap-8 md:grid-cols-3">

          {tickets.map((ticket) => (
            <TicketCard
              key={ticket.id}
              name={ticket.name}
              price={ticket.price}
              quota={ticket.quota}
              description={ticket.description}
            />
          ))}

        </div>

      </div>
    </section>
  );
}
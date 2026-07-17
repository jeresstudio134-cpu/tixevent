import Navbar from "@/components/layout/Navbar";
import Hero from "@/components/sections/Hero";
import About from "@/components/sections/About";
import TicketSection from "@/components/sections/TicketSection";

export default function Home() {
  return (
    <>
      <Navbar />
      <Hero />
      <About />
      <TicketSection />
    </>
  );
}
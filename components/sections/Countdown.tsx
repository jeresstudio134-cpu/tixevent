"use client";

import { useEffect, useState } from "react";

export default function Countdown() {
  const target = new Date("2026-06-18T19:00:00").getTime();

  const [timeLeft, setTimeLeft] = useState(target - Date.now());

  useEffect(() => {
    const timer = setInterval(() => {
      setTimeLeft(target - Date.now());
    }, 1000);

    return () => clearInterval(timer);
  }, [target]);

  if (timeLeft <= 0) {
    return (
      <div className="text-xl font-bold text-red-500">
        Event Dimulai
      </div>
    );
  }

  const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
  const hours = Math.floor((timeLeft / (1000 * 60 * 60)) % 24);
  const minutes = Math.floor((timeLeft / (1000 * 60)) % 60);
  const seconds = Math.floor((timeLeft / 1000) % 60);

  const items = [
    { label: "Hari", value: days },
    { label: "Jam", value: hours },
    { label: "Menit", value: minutes },
    { label: "Detik", value: seconds },
  ];

  return (
    <div className="mt-10 flex justify-center gap-4">
      {items.map((item) => (
        <div
          key={item.label}
          className="min-w-[80px] rounded-xl bg-white/10 p-4 text-center backdrop-blur"
        >
          <div className="text-3xl font-bold text-white">
            {String(item.value).padStart(2, "0")}
          </div>
          <div className="text-sm text-gray-300">
            {item.label}
          </div>
        </div>
      ))}
    </div>
  );
}
import "./globals.css";

export const metadata = {
  title: "Ticket Event",
  description: "Website Ticket Event",
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="id">
      <body>{children}</body>
    </html>
  );
}
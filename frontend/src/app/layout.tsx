import './globals.css';
import type { Metadata } from 'next';

export const metadata: Metadata = {
  title: 'Stock Commerce',
  description: 'Next.js 16 storefront powered by Laravel 12 API'
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="en">
      <body>{children}</body>
    </html>
  );
}

import { ProductCard } from '@/components/product-card';
import { getProducts } from '@/lib/api';

export default async function HomePage() {
  const products = await getProducts();

  return (
    <main className="container">
      <header>
        <p className="eyebrow">Stock Commerce</p>
        <h1>Modern ecommerce starter</h1>
        <p>
          Next.js 16 handles the storefront while Laravel 12 serves product, cart, and order APIs.
        </p>
      </header>
      <section className="product-grid">
        {products.map((product) => (
          <ProductCard key={product.id} product={product} />
        ))}
      </section>
    </main>
  );
}

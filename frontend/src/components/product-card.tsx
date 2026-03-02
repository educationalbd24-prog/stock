import { Product } from '@/lib/types';

type ProductCardProps = {
  product: Product;
};

export function ProductCard({ product }: ProductCardProps) {
  return (
    <article className="card">
      <img src={product.image_url} alt={product.name} className="card-image" />
      <div>
        <p className="card-category">{product.category.name}</p>
        <h2>{product.name}</h2>
        <p>{product.description}</p>
        <p className="card-price">${product.price}</p>
        <button type="button" className="card-button">
          Add to cart
        </button>
      </div>
    </article>
  );
}

import { Product } from './types';

const API_BASE_URL = process.env.NEXT_PUBLIC_API_BASE_URL ?? 'http://localhost:8000/api';

export async function getProducts(): Promise<Product[]> {
  const response = await fetch(`${API_BASE_URL}/products`, {
    next: { revalidate: 60 }
  });

  if (!response.ok) {
    throw new Error('Unable to load products from Laravel API');
  }

  const payload = await response.json();
  return payload.data as Product[];
}

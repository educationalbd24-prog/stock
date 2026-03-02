export type Product = {
  id: number;
  name: string;
  description: string;
  price: string;
  image_url: string;
  category: {
    id: number;
    name: string;
    slug: string;
  };
};

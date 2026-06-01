export interface Category {
    id: number;
    parent_id?: number | null;
    name: string;
    slug: string;
    description: string | null;
    image: string | null;
    url: string | null;
    products_count?: number;
    children?: Category[];
    created_at: string;
    updated_at: string;
}

export interface Product {
    id: number;
    category_id: number;
    name: string;
    slug: string;
    description: string | null;
    base_price: number;
    is_active: boolean;
    category?: Category;
    created_at: string;
    updated_at: string;
}

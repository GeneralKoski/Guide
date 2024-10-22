export interface PostImage {
    id: string;
    name: string;
    alt: string;
    url: string;
}

export interface PostCategory {
    id: string;
    description?: string;
    name: string;
}

export interface PostTag {
    id: string;
    name: string;
}

export interface Post {
    id: string;
    documentId: string;
    title: string;
    excerpt: string;
    content: string;
    date: string;
    images: PostImage[];
    categories?: PostCategory[];
    tags?: PostTag[];
}
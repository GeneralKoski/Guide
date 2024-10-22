export interface Thumbnail {
    name: string;
    hash: string;
    ext: string;
    mime: string;
    path?: any;
    width: number;
    height: number;
    size: number;
    sizeInBytes: number;
    url: string;
  }
  export interface Formats {
    thumbnail: Thumbnail;
  }
  export interface Image {
    id: number;
    documentId: string;
    name: string;
    alternativeText?: any;
    caption?: any;
    width: number;
    height: number;
    formats: Formats;
    hash: string;
    ext: string;
    mime: string;
    size: number;
    url: string;
    previewUrl?: any;
    provider: string;
    provider_metadata?: any;
    createdAt: string;
    updatedAt: string;
    publishedAt: string;
    locale?: any;
  }
  export interface Category {
    id: number;
    documentId: string;
    name: string;
    description?: any;
    createdAt: string;
    updatedAt: string;
    publishedAt: string;
    locale?: any;
  }
  export  interface Tag {
    id: number;
    documentId: string;
    name: string;
    createdAt: string;
    updatedAt: string;
    publishedAt: string;
    locale?: any;
  }
  
  export interface Pagination {
    start: number;
    limit: number;
    total: number;
  }

  export interface PostDatum {
    id: number;
    documentId: string;
    title: string;
    excerpt: string;
    content: string;
    createdAt: string;
    updatedAt: string;
    publishedAt: string;
    locale?: any;
    date: string;
    images: Image[];
    categories: Category[];
    tags: Tag[];
  }
  export interface Meta {
    pagination: Pagination;
  }
  export interface PostResponse {
    data: PostDatum[];
    meta: Meta;
  }
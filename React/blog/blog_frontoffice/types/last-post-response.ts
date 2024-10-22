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
  }
export interface Pagination {
    page: number;
    pageSize: number;
    pageCount: number;
    total: number;
  }
  export interface Meta {
    pagination: Pagination;
  }
  export interface LastPostResponse {
    data: PostDatum[];
    meta: Meta;
  }
export interface TagDatum {
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
  export interface Meta {
    pagination: Pagination;
  }
  export interface TagResponse {
    data: TagDatum[];
    meta: Meta;
  }
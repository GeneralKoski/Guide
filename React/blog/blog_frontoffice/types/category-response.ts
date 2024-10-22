export interface CategoryDatum {
    id: number;
    documentId: string;
    name: string;
    description?: any;
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

export interface CategoryResponse {
    data: CategoryDatum[];
    meta: Meta;
}
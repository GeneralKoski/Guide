import { Post } from "./post";

export interface Category {
    name: string;
    posts: Post[];
}
import { CategoryResponse } from "@/types/category-response";
import { LastPostResponse } from "@/types/last-post-response";
import { TagResponse } from "@/types/tag-response";
import axios from "axios";

export const BASE_URL = process.env.NEXT_PUBLIC_BASE_URL;
export const CATEGORIES_ENDPOINT = "/api/categories";
export const TAGS_ENDPOINT = "/api/tags";
export const POSTS_ENDPOINT = "/api/posts";

// USANDO AXIOS
// export const getTopCategories = async () => {
//     const response = await axios.get<CategoryResponse>(
//         `${BASE_URL}${CATEGORIES_ENDPOINT}?pagination[limit]=5&sort=createdAt:desc`
//     );
//     return response.data ? response.data.data : [];
// }

export const getTopCategories = async () => {
  const response =  (await fetch(
    `${BASE_URL}${CATEGORIES_ENDPOINT}?pagination[limit]=5&sort=createdAt:desc`
  ))
  const posts = await response.json();
  return posts.data;
}

// USANDO AXIOS
// export const getTopTags = async () => {
//     const response = await axios.get<TagResponse>(
//       `${BASE_URL}${TAGS_ENDPOINT}?pagination[limit]=5&sort=createdAt:desc`
//     );
//     return response.data ? response.data.data : [];
// }

export const getTopTags = async () => {
  const response = (await fetch(
    `${BASE_URL}${TAGS_ENDPOINT}?pagination[limit]=5&sort=createdAt:desc`
  ))
  const posts = await response.json();
  return posts.data;
}

// USANDO AXIOS
// export const getLastPosts = async (limit = 3) => {
//     const response = await axios.get<LastPostResponse>(
//         `${BASE_URL}${POSTS_ENDPOINT}?pagination[limit]=${limit}&sort=date:desc`
//     );
//     return response.data ? response.data.data : [];
    
// }

export const getLastPosts = async () => {
  const response = (await fetch(
    `${BASE_URL}${POSTS_ENDPOINT}?&sort=date:desc`
  ))
  const posts = await response.json();
  return posts.data
}

export const getPosts = async () => {
  const res =  (await fetch(
    `${BASE_URL}${POSTS_ENDPOINT}?populate=images&populate=categories&populate=tags&pagination[limit]=6&sort=date:desc`
  ))
  const posts = await res.json();
  return posts;
}

export const getPost = async (id: string) => {
  const res =  (await fetch(
    `${BASE_URL}${POSTS_ENDPOINT}/crx4p95u3azia89wt7d7az8o?populate=images&populate=categories&populate=tags`
  ))

  //console.log(`${BASE_URL}${POSTS_ENDPOINT}/${id}?populate=images&populate=categories&populate=tags`)
  
  const posts = await res.json();

  //console.log("res", res.status, res.statusText)

  return posts;
}

export const getPostByCategory = async () => {
  const res = (await fetch(
    `${BASE_URL}${CATEGORIES_ENDPOINT}?populate=posts`
  ))

  const posts = await res.json();
  return posts;
  // const response = await axios.get<PostCategoryResponse>(`${BASE_URL}${CATEGORIES_ENDPOINT}/${id}?populate=posts`);

  // const { name, posts } = response.data.data;
  // const category = {
  //   name, 
  //   posts: posts.data.map(post => {
  //     const {title, excerpt, content, date} = post;
  //     return {
  //       id: post.id,
  //       title,
  //       excerpt, 
  //       content,
  //       date
  //     }
  //   })
  // }
}

export const getPostByTag = async (id: string) => {
  const res = (await fetch(
    `${BASE_URL}${TAGS_ENDPOINT}/${id}?populate=posts`
  ))
  const posts = await res.json();
  return posts;
  // const response = await axios.get<PostTagResponse>(`${BASE_URL}${TAGS_ENDPOINT}/${id}?populate=posts`);

  // const { name, posts } = response.data.data;
  // const tag = {
  //   name: name, 
  //   posts: posts.data.map(post => {
  //     const {title, excerpt, content, date} = post;
  //     return {
  //       id: post.id,
  //       title,
  //       excerpt, 
  //       content,
  //       date
  //     }
  //   })
  // }
}


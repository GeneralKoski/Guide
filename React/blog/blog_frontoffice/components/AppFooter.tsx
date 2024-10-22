import { getLastPosts, getTopCategories, getTopTags } from "@/api/strapi";
import { CategoryDatum } from "@/types/category-response";
import { PostDatum } from "@/types/last-post-response";
import { TagDatum } from "@/types/tag-response";
import { slug } from "@/utils/utils";
import Image from "next/image";
import Link from "next/link";
import { useEffect, useState } from "react";

const AppFooter: React.FC = () => {
  const [categories, setCategories] = useState<CategoryDatum[]>([]);
  const [tags, setTags] = useState<TagDatum[]>([]);
  const [lastPosts, setLastPosts] = useState<PostDatum[]>([]);

  useEffect(() => {
    const getCategories = async () => {
      const data = await getTopCategories();
      setCategories(data);
    };

    const getTags = async () => {
      const data = await getTopTags();
      setTags(data);
    };

    const getPosts = async () => {
      const data = await getLastPosts();
      setLastPosts(data);
    };

    getCategories();
    getTags();
    getPosts();
  }, []);
  return (
    <footer>
      <section className="footer-top">
        <div className="container">
          <div className="footer-tab footer-info">
            <div className="footer-logo">
              <Image
                src="/images/logo.png"
                alt="C Thech Logo"
                width="110"
                height="47"
              />
            </div>
            <p>Miglior blog di tecnologia e gadgets</p>
          </div>
          <div className="footer-tab footer-nav">
            <h3>Categorie</h3>
            <ul>
              {categories.length > 0 &&
                categories.map((category: CategoryDatum) => {
                  return (
                    <li key={category.id}>
                      <Link
                        className="btn btn-white"
                        href={`/categories/${category.id}`}
                      >
                        {category.name}
                      </Link>
                    </li>
                  );
                })}
            </ul>
          </div>
          <div className="footer-tab footer-tags">
            <h3>Tags</h3>
            {tags.length > 0 &&
              tags.map((tag: TagDatum) => {
                return (
                  <Link
                    className="btn btn-white btn-full btn-full-white"
                    key={tag.id}
                    href={`/tags/${tag.id}`}
                  >
                    {tag.name}
                  </Link>
                );
              })}
          </div>
          <div className="footer-tab footer-recent-posts">
            <h3>Post Recenti</h3>
            {lastPosts &&
              lastPosts.map((post: PostDatum) => {
                return (
                  <div key={post.id} className="recent-post">
                    <div className="recent-text">
                      <h4 className="recent-title">
                        <Link
                          className="btn btn-white truncate"
                          href={`/posts/${post.id}`}
                        >
                          {post.title}
                        </Link>
                      </h4>
                    </div>
                    <div className="recent-date">{post.date}</div>
                  </div>
                );
              })}
          </div>
        </div>
      </section>
    </footer>
  );
};

export default AppFooter;

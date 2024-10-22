import { getPosts } from "@/api/strapi";
import { Post } from "@/types/post";
import { GetServerSideProps } from "next";
import Image from "next/image";
import Link from "next/link";

type Props = {
  post: Post;
};

const PostPreview: React.FC<Props> = ({ post }) => {
  const { id, title, excerpt, date, images, categories } = post;
  const image = images ? images[0] : null;
  const category = categories ? categories[0] : null;

  return (
    <div className="post">
      <div className="post-img">
        {image && (
          <Image
            src={`http://localhost:1337${image.url}`}
            width={578}
            height={325}
            alt={image.alt}
          ></Image>
        )}
      </div>
      <div className="post-text">
        <h3>
          <Link className="btn btn-black" href={`/posts/${id}`}>
            {title}
          </Link>
        </h3>
        <span>
          {category && (
            <Link className="btn btn-black" href={`/categories/${category.id}`}>
              {category.name}
            </Link>
          )}
        </span>
        <span className="bar"></span>
        <span>{date}</span>
        <p className="truncate">{excerpt}</p>
        <span className="bar"></span>
        <span>
          <Link className="btn btn-black" href={`/posts/${id}`}>
            Leggi tutto
          </Link>
        </span>
      </div>
    </div>
  );
};

export default PostPreview;

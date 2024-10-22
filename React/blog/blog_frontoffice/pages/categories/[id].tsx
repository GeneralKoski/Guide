import { getPosts } from "@/api/strapi";
import PostPreview from "@/components/PostPreview";
import { Post } from "@/types/post";
import { GetServerSideProps, NextPage } from "next";
import Head from "next/head";

type Props = {
  posts: Post[];
};

const CategoryPage: NextPage<Props> = ({ posts }) => {
  return (
    <div>
      <Head>
        <title>C Tech - "categoria"</title>
        <meta name="description" content="C-Tech" />
      </Head>
      <main>
        <section className="jumbo">
          <div className="container">
            <h1>Categoria: "la categoria" </h1>
          </div>
        </section>

        <section className="posts">
          <div className="container">
            {posts &&
              posts?.map((post) => {
                return <PostPreview key={post.id} post={post} />;
              })}
          </div>
        </section>
      </main>
    </div>
  );
};

export default CategoryPage;

export const getServerSideProps: GetServerSideProps = async () => {
  try {
    const posts = await getPosts();

    return {
      props: {
        posts: posts.data,
      },
    };
  } catch (error) {
    return {
      notFound: true,
    };
  }
};

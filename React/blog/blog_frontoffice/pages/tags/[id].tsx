import { getPostByTag, getPosts } from "@/api/strapi";
import PostPreview from "@/components/PostPreview";
import { Post } from "@/types/post";
import { GetServerSideProps, GetServerSidePropsContext, NextPage } from "next";
import Head from "next/head";

type Props = {
  posts: Post[];
};

const TagPage: NextPage<Props> = ({ posts }) => {
  return (
    <div>
      <Head>
        <title>C Tech - {posts}</title>
        <meta name="description" content="C-Tech" />
      </Head>
      <main>
        <section className="jumbo">
          <div className="container">
            <h1>Tag: "tag" </h1>
          </div>
        </section>
        <section className="posts">
          <div className="container">
            {posts &&
              posts?.map((post) => {
                console.log(posts);
                return <PostPreview key={post.id} post={post} />;
              })}
          </div>
        </section>
      </main>
    </div>
  );
};

export default TagPage;

export const getServerSideProps: GetServerSideProps = async () => {
  try {
    const posts = await getPosts();

    // Filtra i post per mostrare solo quelli con category.id uguale a 5
    const filteredPosts = posts.data.filter((post: Post) =>
      post.categories.some((category: { id: number }) => category.id === 5)
    );

    return {
      props: {
        posts: filteredPosts,
      },
    };
  } catch (error) {
    return {
      notFound: true,
    };
  }
};

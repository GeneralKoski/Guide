import { getPosts } from "@/api/strapi";
import PostPreview from "@/components/PostPreview";
import { Post } from "@/types/post";
import { GetServerSideProps, NextPage } from "next";
import Head from "next/head";
import Image from "next/image";
import Link from "next/link";

type Props = {
  posts: Post[];
};

const Home: NextPage<Props> = ({ posts }) => {
  return (
    <div>
      <Head>
        <title>C Tech</title>
        <meta
          name="description"
          content="Miglior blog sulla tecnologia e i gadget"
        />
        <link rel="icon" href="../public/favicon.ico" />
      </Head>
      <main>
        <section className="posts">
          <div className="container">
            {posts &&
              posts.map((post) => {
                console.log(post);
                return <PostPreview key={post.id} post={post} />;
              })}
          </div>
        </section>
      </main>
    </div>
  );
};

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

export default Home;

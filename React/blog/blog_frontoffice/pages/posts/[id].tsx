import { getPost } from "@/api/strapi";
import { Post } from "@/types/post";
import { GetServerSideProps, GetServerSidePropsContext, NextPage } from "next";
import Head from "next/head";
import Image from "next/image";
import Link from "next/link";
import ReactMarkdown from "react-markdown";

type Props = {
  post: Post;
};

const PostPage: NextPage<Props> = ({ post }) => {
  return (
    <div>
      <Head>
        <title>C Tech - il titolo </title>
        <meta
          name="description"
          content="Milgior blog sulla tecnologia e i gadget"
        />
      </Head>
      <main>
        <section className="post-detail">
          <div className="container">
            <h1>il titolo</h1>
            <small>la data</small>
            <div className="post-img">
              {post.images && (
                <Image
                  src={`http://localhost:1337/${post.images}`}
                  width={578}
                  height={325}
                  alt="l'immagine"
                ></Image>
              )}
            </div>
            <p>l'excerpt</p>
            <ReactMarkdown>Il contenuto</ReactMarkdown>
          </div>
        </section>

        <section className="post-category-tags">
          <div className="container">
            <div className="category">
              <h4>CATEGORIA: </h4>
              la categoria
            </div>
            <div className="tags">
              <h4>TAG: </h4>
              il tag
            </div>
          </div>
        </section>

        <section className="post-author">
          <div className="container">
            <div className="author-logo">
              <Image
                src="/images/stickman.jpg"
                width={150}
                height={150}
                alt="Foto profilo"
              />
            </div>
            <div className="author-text">
              <h2>
                <Link legacyBehavior href="/">
                  <a className="btn btn-black">Trajkovski Martin</a>
                </Link>
              </h2>
              <div className="author-comment">
                Ci sto provando a fare qualcosa
              </div>
            </div>
          </div>
        </section>
      </main>
    </div>
  );
};

export default PostPage;

export const getServerSideProps: GetServerSideProps = async (
  context: GetServerSidePropsContext
) => {
  const id = context.params?.id?.toString();
  const post = id ? await getPost(id) : null;
  console.log(post);
  try {
    return {
      props: {
        post: post.data,
      },
    };
  } catch (error) {
    return {
      notFound: true,
    };
  }
};

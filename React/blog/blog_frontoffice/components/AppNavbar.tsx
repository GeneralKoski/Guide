import { getTopCategories } from "@/api/strapi";
import { CategoryDatum } from "@/types/category-response";
import { GetServerSideProps } from "next";
import Image from "next/image";
import Link from "next/link";
import { useEffect, useState } from "react";

const AppNavbar: React.FC = () => {
  const [categories, setCategories] = useState<CategoryDatum[]>([]);
  const [active, setActive] = useState(false);

  useEffect(() => {
    const getCategories = async () => {
      const data = await getTopCategories();
      setCategories(data);
    };

    getCategories();
  }, []);

  return (
    <header>
      <section className="header-bottom">
        <div className="container">
          <div className="head-container">
            <div className="head-bottom-left">
              <div className="logo-container">
                <Link href="/">
                  <Image
                    src="/images/logo.png"
                    alt="C Tech Logo"
                    width="110"
                    height="47"
                  />
                </Link>
              </div>
            </div>
            <div className="head-bottom right">
              <ul className="header-nav">
                <li>
                  <Link className="btn btn-black" href="/">
                    Home
                  </Link>
                </li>
                {categories.map((category: CategoryDatum) => {
                  return (
                    <li key={category.id}>
                      <Link
                        className="btn btn-black"
                        href={`/categories/${category.name.toLowerCase()}`}
                      >
                        {category.name}
                      </Link>
                    </li>
                  );
                })}
              </ul>
              <ul>
                <li
                  className="hamb-menu btn btn-black"
                  onClick={() => setActive(!active)}
                >
                  <i className="fas fa-bars"></i>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div
          className={`mobile-tablet-hamb-menu ${
            active ? "mobile-menu-active" : ""
          }`}
        >
          <ul>
            <li>
              <Link className="btn btn-black" href="/">
                Home
              </Link>
            </li>
            {categories.length > 0 &&
              categories.map((category: CategoryDatum) => {
                return (
                  <li key={category.id}>
                    <Link
                      className="btn btn-black"
                      href={`/categories/${category.id}`}
                    >
                      {category.name}
                    </Link>
                  </li>
                );
              })}
            <li
              className="btn btn-black close-menu"
              onClick={() => setActive(!active)}
            >
              <i className="fas fa-times"></i>
            </li>
          </ul>
        </div>
      </section>
    </header>
  );
};

export default AppNavbar;

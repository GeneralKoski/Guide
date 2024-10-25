import clsx from "clsx";
import Image from "next/image";
import { ReactNode } from "react";

interface LateraleButtonProps {
  id: string;
  src: string;
  alt: string;
  title: string;
}

export const LateraleButton = ({
  id,
  src,
  alt,
  title,
}: LateraleButtonProps) => {
  return (
    <li>
      <a href="#" onClick={() => alert(`Hai cliccato su ${title}`)}>
        <Image
          className="img-fluid inverso"
          src={src}
          alt={alt}
          title={title}
          width={30}
          height={30}
        />
      </a>
    </li>
  );
};

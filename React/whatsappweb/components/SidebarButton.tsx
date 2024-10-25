import clsx from "clsx";
import Image from "next/image";
import { ReactNode } from "react";

interface SidebarButtonProps {
  id: string;
  icon: string;
  alt: string;
  title: string;
  selected?: boolean;
  onClick: (id: string) => void;
  children?: ReactNode;
}

export const SidebarButton = ({
  selected,
  id,
  icon,
  alt,
  title,
  children,
  onClick,
}: SidebarButtonProps) => {
  return (
    <li
      className={clsx(`icone`)}
      style={{
        background: selected ? "#56595c" : "transparent",
      }}
    >
      <div onClick={() => onClick(id)}>
        <Image
          className="img-fluid inverso"
          src={icon}
          alt={alt}
          title={title}
          width={35}
          height={35}
        />
      </div>
      {children}
    </li>
  );
};

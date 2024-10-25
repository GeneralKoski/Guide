import clsx from "clsx";
import Image from "next/image";
import { ReactNode } from "react";

interface SidebarButtonProps {
  id: string;
  icon: string;
  selected?: boolean;
  onClick: (id: string) => void;
  children?: ReactNode;
}

export const SidebarButton = ({
  selected,
  id,
  icon,
  children,
  onClick,
}: SidebarButtonProps) => {
  return (
    <li
      className={clsx(`icone`)}
      style={{
        background: selected ? "rgba(255,0,0,0.4)" : "transparent",
      }}
    >
      <div onClick={() => onClick(id)}>
        <Image
          className="img-fluid inverso"
          src={icon}
          alt="Chat"
          title="Chat"
          width={35}
          height={35}
        />
      </div>
      {children}
    </li>
  );
};

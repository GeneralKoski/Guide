import clsx from "clsx";
import Image from "next/image";

interface SidebarButtonProps {
  id: string;
  icon: string;
  alt: string;
  title: string;
  selected?: boolean;
  onClick: (id: string) => void;
  className?: string;
}

export const SidebarButton = ({
  selected,
  id,
  icon,
  alt,
  title,
  onClick,
  className,
}: SidebarButtonProps) => {
  return (
    <li
      className={clsx(`icone`)}
      style={{
        background: selected ? "#56595c" : "transparent",
      }}
      onClick={() => onClick(id)}
    >
      <Image
        className={clsx("img-fluid", className)}
        src={icon}
        alt={alt}
        title={title}
        height={35}
        width={35}
      />
    </li>
  );
};

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
  const imageSrc = icon || "/images/default_icon.jpg";
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
        src={imageSrc}
        alt={alt}
        title={title}
        width={35}
        height={35}
      />
    </li>
  );
};

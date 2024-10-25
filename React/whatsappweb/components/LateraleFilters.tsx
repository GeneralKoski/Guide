import clsx from "clsx";
import Image from "next/image";
import { ReactNode } from "react";

interface LateraleFiltersProps {
  id: string;
  filterName: string;
}

export const LateraleFilters = ({ id, filterName }: LateraleFiltersProps) => {
  return (
    <li>
      <a href="#">{filterName}</a>
    </li>
  );
};

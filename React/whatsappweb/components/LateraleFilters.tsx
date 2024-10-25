interface LateraleFiltersProps {
  filterName: string;
}

export const LateraleFilters = ({ filterName }: LateraleFiltersProps) => {
  return (
    <li>
      <a href="#">{filterName}</a>
    </li>
  );
};

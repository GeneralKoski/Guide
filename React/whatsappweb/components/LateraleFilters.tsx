interface LateraleFiltersProps {
  filterName: string;
}

export const LateraleFilters = ({ filterName }: LateraleFiltersProps) => {
  return <a href="#">{filterName}</a>;
};

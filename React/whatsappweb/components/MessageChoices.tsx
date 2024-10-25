interface MessageChoicesProps {
  choiceName: string;
}

export const MessageChoices = ({ choiceName }: MessageChoicesProps) => {
  return (
    <li className="list-group-item list-group-item-action border-0 text-white">
      {choiceName}
    </li>
  );
};

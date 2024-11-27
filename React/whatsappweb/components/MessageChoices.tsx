interface MessageChoicesProps {
  isAdmin: string;
  choiceName: string;
  chatType: string;
}

export const MessageChoices = ({
  isAdmin,
  choiceName,
  chatType,
}: MessageChoicesProps) => {
  if (chatType == "single") {
    return (
      <li className="list-group-item list-group-item-action border-0 text-white">
        {choiceName}
      </li>
    );
  } else {
    if (choiceName == "Elimina" && isAdmin == "false") {
      return null;
    }
    return (
      <li className="list-group-item list-group-item-action border-0 text-white">
        {choiceName}
      </li>
    );
  }
};

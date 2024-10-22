export const slug = (title: String) => {
    return title.trim().replaceAll(' ', '-').toLowerCase().replaceAll(' ', '').replaceAll('.', '');
}


interface User {
    id: number;
    name: string;
}

const list: Array<User> = [
    { id: 1, name: 'Fabio' },
    { id: 2, name: 'Lorenzo' },
    { id: 3, name: 'Lisa' },
];

console.log(list[0].name)
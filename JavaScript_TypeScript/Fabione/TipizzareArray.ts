interface Utente {
    id: number;
    name: string;
}

const list: Array<Utente> = [
    { id: 1, name: 'Fabio' },
    { id: 2, name: 'Lorenzo' },
    { id: 3, name: 'Lisa' },
];

console.log(list[0].name)
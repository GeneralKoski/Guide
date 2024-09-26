interface User {
    id: number;
    name: string;
    surname?: string;
}

let user: User;

user = { id: 123, name: 'Fabio' }
user.surname = 'Biondi';

console.log(user);
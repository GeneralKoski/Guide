class Pippo {
    constructor() {
        console.log('constructor');
    }
    hello(value) {
        console.log("Ciao " + value);
    }
}

class Pluto extends Pippo {
    then(arg0) {
        throw new Error("Method not implemented.");
    }
}

const p = new Pluto();
p.hello('Fabio');
import Image from "next/image";

const Details: React.FC = () => {
    return (
        <>
            <div className="basic-1">
                <div className="container">
                    <div className="row align-items-center">
                        <div className="col-lg-6 col-xl-5">
                            <div className="text-container">
                                <h2>Consulente Fiscale</h2>
                                <p>Ti proponiamo un consulente dedicato specializzato nel tuo business e pronto a rispondere alle tue doamande.</p>
                                <a className="btn-solid-reg" href="#pricing">Prezzi</a>
                            </div>
                        </div>
                        <div className="col-lg-6 col-xl-7">
                            <div className="image-container">
                                <Image
                                    className="img-fluid"
                                    src="/images/kiwi.svg"
                                    alt="Consulente Fiscale"
                                    width={400}
                                    height={500}
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="basic-2">
                <div className="container">
                    <div className="row align-items-center">
                        <div className="col-lg-6 col-xl-7">
                            <div className="image-container">
                                <Image
                                    className="img-fluid"
                                    src="/images/kiwi.svg"
                                    alt="Consulente Fiscale"
                                    width={400}
                                    height={500}
                                />
                            </div>
                        </div>
                        <div className="col-lg-6 col-xl-5">
                            <div className="text-container">
                                <h2>Applicazione web e mobile</h2>
                                <p>Gestisci tutta la tua attività in modo semplice e intuitivo.</p>
                                <ul className="list-unstyled li-space-lg">
                                    <li className="d-flex">
                                        <i className="fas fa-square"></i>
                                        <div className="flex-grow-1">Organizza i tuoi clienti e fornitori</div>
                                    </li>
                                    <li className="d-flex">
                                        <i className="fas fa-square"></i>
                                        <div className="flex-grow-1">Crea le fatture in pochi secondi</div>
                                    </li>
                                    <li className="d-flex">
                                        <i className="fas fa-square"></i>
                                        <div className="flex-grow-1">Ottieni una previsione di tasse e contributi</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

export default Details;
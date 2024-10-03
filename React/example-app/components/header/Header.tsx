import Image from "next/image";

const AppHeader: React.FC = () => {
    return (
        <header className="header">
            <div className="container">
                <div className="row align-items-center">
                    <div className="col-lg-6">
                        <div className="text-container mt-5">
                            <h1 className="h1-large">La moneta più importante che abbiamo
                                <span> è il tempo</span>
                            </h1>
                            <p className="p-large">EasyFisco gestisce i clienti e la fiscalità per te, per darti modo di dedicare il tuo tempo alle cose più importanti</p>
                            <button className="btn-solid-lg">Dimmi di più</button>
                        </div>
                    </div>
                    <div className="col-lg-6">
                        <Image 
                            className="img-fluid"
                            src="/images/kiwi.svg" 
                            width={200}
                            height={300}
                            alt="Easy Fisco Header Image"
                            priority
                        />
                    </div>
                </div>
            </div>
        </header>
    )
}

export default AppHeader;
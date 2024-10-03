import Link from "next/link";

const AppFooter: React.FC = () => {
    return (
        <footer className="footer">
            <div className="container">
                <div className="row">
                    <div className="col-lg-12">
                        <div className="footer-col first">
                            <h6>EasyFisco</h6>
                            <p>Inizia da subito a risparmiare sul tuo tempo.</p>
                        </div>
                        <div className="footer-col second">
                            <h6>Link utili</h6>
                            <ul className="list-unstyled li-space-lg p-small">
                                <li>Importanti: Termini & Condizioni, Privacy Policy</li>
                                <li>Guide: Regime dei minimi, Cos'è una partita IVA, Fatturazione Elettronica</li>
                                <li>Supporto: <Link legacyBehavior href="/contact"><a>Contattaci</a></Link></li>
                            </ul> 
                        </div>
                        <div className="footer-col third">
                            <span className="fa-stack">
                                <Link legacyBehavior href="/">
                                <a>
                                    <i className="fas fa-circle fa-stack-2x"></i>
                                    <i className="fab fa-facebook-f fa-stack-1x"></i>
                                </a>
                                </Link>
                            </span>
                            <span className="fa-stack">
                                <Link legacyBehavior href="/">
                                <a>
                                    <i className="fas fa-circle fa-stack-2x"></i>
                                    <i className="fab fa-twitter fa-stack-1x"></i>
                                </a>
                                </Link>
                            </span>
                            <span className="fa-stack">
                                <Link legacyBehavior href="/">
                                <a>
                                    <i className="fas fa-circle fa-stack-2x"></i>
                                    <i className="fab fa-pinterest-p fa-stack-1x"></i>
                                </a>
                                </Link>
                            </span>
                            <span className="fa-stack">
                                <Link legacyBehavior href="/">
                                <a>
                                    <i className="fas fa-circle fa-stack-2x"></i>
                                    <i className="fab fa-instagram fa-stack-1x"></i>
                                </a>
                                </Link>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>   
    )
}

export default AppFooter;
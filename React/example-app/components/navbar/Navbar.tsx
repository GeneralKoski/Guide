import Link from "next/link"

const Navbar: React.FC = () => {
    return (
        <nav id="myNavbar" className="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
            <div className="container">
                <a className="navbar-brand logo-text">EasyFisco</a>

                <button className="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarSupportedContent" aria-expanded="false" id="navbarSideCollapse" aria-label="Toggle navigation">
                    <span className="navbar-toggler-icon"></span>
                </button>

                <div className="navbar-collapse offcanvas-collapse collapse" id="navbarMain">
                    <ul className="navbar-nav ms-auto navbar-nav-scroll">
                        <li className="nav-item">
                            <Link legacyBehavior href="/">
                                <a className="nav-link">Home</a>
                            </Link>
                        </li>
                        <li className="nav-item">
                            <Link legacyBehavior href="/#features">
                            <a className="nav-link">Funzionalità</a>
                            </Link>
                        </li>
                        <li className="nav-item">
                            <Link legacyBehavior href="/#details">
                            <a className="nav-link">Dettagli</a>
                            </Link>
                        </li>
                        <li className="nav-item">
                            <Link legacyBehavior href="/#price">
                            <a  className="nav-link">Prezzi</a>
                            </Link>
                        </li>
                        <li className="nav-item">
                            <Link legacyBehavior href="/contact">
                            <a className="nav-link">Contattaci</a>
                            </Link>
                        </li>
                    </ul>
                    <span className="nav-item">
                        <a className="btn-outline-sm" href="#">Accedi</a>
                    </span>
                </div>
            </div>
        </nav>
    )
}

export default Navbar
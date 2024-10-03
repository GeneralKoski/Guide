import { Feature } from "@/types";


const Features: React.FC<{ items: Feature[] }> = ({items}) => {
    return (
        <div id="features" className="cards-1">
            <div className="container">
                <div className="row">
                    <div className="col-lg-12">
                        <h2 className="heading">
                            EasyFisco ha tutte le caratteristiche di cui <span>hai bisogno</span>
                        </h2>
                    </div>
                </div>
                <div className="row">
                    <div className="col-lg-12">
                        {
                            items && items.map((feature: Feature) => {
                                return (
                                    <div key={feature.id.toString()} className="card">
                                        <div className={`card-icon ${feature.iconColor}`}>
                                            <span className={`${feature.icon}`}></span>
                                        </div>
                                        <div className="card-body">
                                            <h4 className="card-title">{feature.name}</h4>
                                            <p>{feature.description}</p>
                                        </div>
                                    </div>
                                )
                            })
                        }
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Features;
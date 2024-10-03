import { Price } from "@/types";
import Image from "next/image";
import Link from "next/link";

interface PricingProps {
    items: Price[];
}

const Pricing: React.FC<PricingProps> = ({items}) => {
    return (
        <div className="cards-2">
            <div className="container">
                <div className="row">
                    <div className="col-lg-12">
                        <h2 className="heading">Un piano per ogni esigenza</h2>
                    </div>
                </div>
                <div className="row">
                    <div className="col-lg-12">
                        {
                            items && items.map((item: Price) => {
                                return (
                                <div className="card" key={item.id.toString()}>
                                    <div className="card-body">
                                        <div className="card-title">
                                            <Image className="decoration-lines" src="/images/kiwi.svg" alt="alternative" height={9.75} width={30}></Image>
                                            <span>{item.name}</span>
                                            <Image className="decoration-lines flipped" src="/images/kiwi.svg" alt="alternative" height={9.75} width={30}></Image>
                                        </div>
                                        <ul className="list-unstyled li-space-lg">
                                            {
                                                item.features.map((feature: String, index: number) => {
                                                    return (
                                                        <li key={`${feature}-${index}`}>-{feature}</li>
                                                    )
                                                })
                                            }
                                        </ul>
                                        <div className="price">{item.value}<span>/anno</span></div>
                                        <Link legacyBehavior href="/contact">
                                            <a className="btn-solid-reg">Contattaci</a>
                                        </Link>
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

export default Pricing;
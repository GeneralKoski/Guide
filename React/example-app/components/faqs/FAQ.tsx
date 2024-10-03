import { Question } from "@/types";
import { useState } from "react";

type FAQProps = {
    items: Question[];
}

const FAQ: React.FC<FAQProps> = ({ items }) => {
    const [currentId, setCurrentId] = useState<String>(items[0].id);

    function handleClick(id: String) {
        setCurrentId(id);
    }
    
    return (
        <div className="questions">
            <div className="container">
                <div className="row">
                    <div className="col-lg-12">
                        <h2 className="heading">Hai delle curiosità?</h2>
                    </div>
                </div>
                <div className="row">
                    <div className="col-lg-12">
                        <div id="my-accordion" className="accordion">
                            {
                                items && items.map((item: Question) => {
                                    if (item.id === currentId) {
                                        return (
                                            <div className="accordion-item" key={item.id.toString()}>
                                                <h2 className="accordion-header">
                                                    <button className="accordion-button"
                                                        type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target={`#${item.id}`}
                                                        onClick={() => handleClick(item.id)}
                                                    >
                                                        {item.title}
                                                    </button>
                                                    <div id={`${item.id}`}
                                                        className="accordion-collapse collapse"
                                                        data-bs-parent="#my-accordion"
                                                    >
                                                        <div className="accordion-body">
                                                            {item.answer}
                                                        </div>
                                                    </div>
                                                </h2>
                                            </div>
                                        )
                                    } else {
                                        return (
                                            <div className="accordion-item" key={item.id.toString()}>
                                                <h2 className="accordion-header">
                                                    <button className="accordion-button"
                                                        type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target={`#${item.id}`}
                                                        onClick={() => handleClick(item.id)}
                                                    >
                                                        {item.title}
                                                    </button>
                                                    <div id={`${item.id}`}
                                                        className="accordion-collapse collapse"
                                                        data-bs-parent="#my-accordion"
                                                    >
                                                        <div className="accordion-body">
                                                            {item.answer}
                                                        </div>
                                                    </div>
                                                </h2>
                                            </div>
                                        )
                                    }
                                })
                            }
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default FAQ;
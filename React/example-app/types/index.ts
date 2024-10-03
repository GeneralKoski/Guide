export type Feature = {
    id: String;
    name: String;
    icon: String;
    iconColor: String;
    description: String;
}

export type Price = {
    id: String;
    name: String;
    features: String[];
    value: String;
}

export type Question = {
    id: String;
    title: String;
    answer: String;
}

export type ContactForm = {
    fullName: string;
    email: string;
    phoneNumber: string;
    coupon?: string;
    hasPartitaIVA: string;
    privacy: boolean;
}
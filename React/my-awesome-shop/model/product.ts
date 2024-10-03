export interface Product {
    id: string;
    Status: string;
    Description: string;
    Categories: string[];
    Image: Image[];
    Title: string;
    Qty: number;
    Price: number;
    Calculation: number;
    CategoriesImage: Image[];
    CategoriesTitle: string[];
  }
  
  export interface Image {
    id: string;
    width: number;
    height: number;
    url: string;
    filename: string;
    size: number;
    type: string;
    thumbnails: Thumbnails;
  }
  
  export interface Thumbnails {
    small: Small;
    large: Small;
    full: Small;
  }
  
  export interface Small {
    url: string;
    width: number;
    height: number;
  }
import { TYPE_EVENT, BRANCH } from '../settings.js'
import { Api } from '../modules/api.js';


export default class Event {

    constructor(title, start, end, description, extendedProps){
        this.title = title;
        this.start = start;
        this.end = end ;
        this.description = description;
        this.extendedProps = extendedProps || [];
    };
}

// event yang berlaku nasional, type global
export class Holiday extends Event {

    primaryColor = '#fc544b';
    secondaryColor = '#fafafa';

    constructor(title, start, end, description, extendedProps, backgroundColor,
        borderColor, textColor) {

        super(title, start, end, description, extendedProps);
        this.backgroundColor = backgroundColor || this.primaryColor;
        this.borderColor = borderColor || this.primaryColor;
        this.textColor = textColor || this.secondaryColor;
    }
    
}

// event yang berlaku untuk seluruh karyawan, type branch
export class Cuti extends Event {

    primaryColor = '#e83e8c';
    secondaryColor = '#fafafa';

    constructor(title, start, end, description, extendedProps, backgroundColor,
        borderColor, textColor) {

        super(title, start, end, description, extendedProps);
        this.backgroundColor = backgroundColor || this.primaryColor;
        this.borderColor = borderColor || this.primaryColor;
        this.textColor = textColor || this.secondaryColor;
    }
    
}

// event yang berlaku untuk group, type group
export class Meeting extends Event {

    primaryColor = '#47c363';
    secondaryColor = '#fafafa';

    constructor(title, start, end, description, extendedProps, backgroundColor,
        borderColor, textColor) {

        super(title, start, end, description, extendedProps);
        this.backgroundColor = backgroundColor || this.primaryColor;
        this.borderColor = borderColor || this.primaryColor;
        this.textColor = textColor || this.secondaryColor;
    }
    
}

// event yang berlaku untuk pribadi, type private
export class Izin extends Event {

    primaryColor = '#3abaf4';
    secondaryColor = '#fafafa';

    constructor(title, start, end, description, extendedProps, backgroundColor,
        borderColor, textColor) {

        super(title, start, end, description, extendedProps);
        this.backgroundColor = backgroundColor || this.primaryColor;
        this.borderColor = borderColor || this.primaryColor;
        this.textColor = textColor || this.secondaryColor;
    }
    
}

// info data izin hris
export class Hris extends Event {

    primaryColor = '#ffa426';
    secondaryColor = '#fafafa';

    constructor(title, start, end, description, extendedProps, backgroundColor,
        borderColor, textColor) {

        super(title, start, end, description, extendedProps);
        this.backgroundColor = backgroundColor || this.primaryColor;
        this.borderColor = borderColor || this.primaryColor;
        this.textColor = textColor || this.secondaryColor;
    }
    
}

// custom function
export function clickMe(params){
    console.log('Click Me', params);
}

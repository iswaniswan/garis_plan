
/**
 * Class Event
 */
class Event {

    constructor(title, start, end, description, extendedProps){
        this.title = title;
        this.start = start;
        this.end = end ;
        this.description = description;
        this.extendedProps = extendedProps || [];
    };
}

// event yang berlaku nasional
class Holiday extends Event {

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

// event yang berlaku untuk seluruh karyawan 
class Cuti extends Event {

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

// event yang berlaku untuk group
class Meeting extends Event {

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

// event yang berlaku untuk pribadi
class Izin extends Event {

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
class Hris extends Event {

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
/*Check if the database exists*/
DROP DATABASE IF EXISTS Sport_Store;
CREATE DATABASE Sport_Store;
/*Use the database*/
USE Sport_Store;
/*User Account Table*/
CREATE TABLE IF NOT EXISTS user_account (
    userID INT NOT NULL AUTO_INCREMENT,
    fullName VARCHAR(45) NOT NULL,
    email VARCHAR(45) NOT NULL,
    contactNum VARCHAR(15) NOT NULL,
    username VARCHAR(45) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (userID),
    UNIQUE INDEX username_UNIQUE (username ASC)
);
/*Product Table*/
CREATE TABLE IF NOT EXISTS product (
    productID INT NOT NULL AUTO_INCREMENT,
    productName VARCHAR(80) NOT NULL,
    productCategory VARCHAR(50) NOT NULL,
    productBrand VARCHAR(45) NOT NULL,
    productType VARCHAR(45) NOT NULL,
    productImagePath TEXT NOT NULL,
    productPrice DECIMAL(10, 2) NOT NULL,
    productDetails TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (productID),
    UNIQUE INDEX productName_UNIQUE (productName ASC)
);
/*Cart Table*/
CREATE TABLE IF NOT EXISTS cart (
    cartID INT NOT NULL AUTO_INCREMENT,
    userID INT NOT NULL,
    productID INT NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (cartID),
    FOREIGN KEY (userID) REFERENCES user_account(userID),
    FOREIGN KEY (productID) REFERENCES product(productID)
);
/*Feedback Table*/
CREATE TABLE IF NOT EXISTS feedback (
    feedbackID INT NOT NULL AUTO_INCREMENT,
    category VARCHAR(45) NOT NULL,
    email VARCHAR(45) NOT NULL,
    contactNum VARCHAR(15) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (feedbackID)
);
/* Order Table */
CREATE TABLE IF NOT EXISTS orders (
    orderID INT NOT NULL AUTO_INCREMENT,
    userID INT NOT NULL,
    address1 VARCHAR(60) NOT NULL,
    address2 VARCHAR(60),
    city VARCHAR(45),
    postcode VARCHAR(10),
    state VARCHAR(45),
    country VARCHAR(45),
    paymentMethod VARCHAR(45),
    totalPrice DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (orderID),
    FOREIGN KEY (userID) REFERENCES user_account(userID)
);
/* OrderProducts Table */
CREATE TABLE IF NOT EXISTS order_product (
    orderProductID INT NOT NULL AUTO_INCREMENT,
    orderID INT NOT NULL,
    productID INT NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (orderProductID),
    FOREIGN KEY (orderID) REFERENCES orders(orderID),
    FOREIGN KEY (productID) REFERENCES product(productID)
);
/*Pre-defined Products*/
INSERT INTO product (
        productName,
        productCategory,
        productBrand,
        productType,
        productImagePath,
        productPrice,
        productDetails
    )
VALUES (
        'ASTROX 88 S PRO',
        'badminton',
        'Yonex',
        'Badminton Racket',
        '../../assets/product image/badminton/ASTROX 88 S PRO.jpg',
        754.90,
        'This badminton racket features a stiff flex frame made of HM Graphite, CFR, and Tungsten, with a HM Graphite shaft incorporating 2G-Namd™ FLEX FORCE and Ultra PE Fiber. It has a built-in T-Joint, is 5 mm longer, and comes in silver and black colors, suitable for stringing within the range of 20-29 lbs. Made in Japan.'
    ),
    (
        'ASTROX 88 S TOUR',
        'badminton',
        'Yonex',
        'Badminton Racket',
        '../../assets/product image/badminton/ASTROX 88 S TOUR.jpg',
        499.90,
        'This badminton racket boasts a stiff flex frame crafted from HM Graphite, CSR, and Tungsten, coupled with a HM Graphite shaft featuring 2G-Namd™ FLEX FORCE technology. With a built-in T-Joint and an extended length of 5 mm, it offers a balanced weight distribution, coming in at an average of 83g for 4U and 88g for 3U, with grip options G5, G6, G4, G5, G6 respectively. It sports a sleek silver and black design and provides stringing advice within the range of 20-29 lbs.'
    ),
    (
        'NANOFLARE NEXTAGE',
        'badminton',
        'Yonex',
        'Badminton Racket',
        '../../assets/product image/badminton/NANOFLARE NEXTAGE.jpg',
        499.90,
        'This badminton racket features a medium flex frame constructed with HT Graphite and Nanocell NEO, along with a Graphite shaft and a built-in T-Joint. It boasts an extended length of 10 mm, providing enhanced reach and maneuverability. Weighing an average of 83g for 4U and with grip option G5, it offers stringing advice within the range of 20-28 lbs. Recommended strings include SKYARC for control players and NANOGY95 for hard hitters. Presented in a stylish white and gray color scheme.'
    ),
    (
        'ASTROX 3 DG ST',
        'badminton',
        'Yonex',
        'Badminton Racket',
        '../../assets/product image/badminton/ASTROX 3 DG ST.jpg',
        710.90,
        'This badminton racket boasts a stiff flex frame made of HM Graphite and Tungsten, complemented by an HM Graphite shaft featuring NANOMESH NEO technology and a built-in T-Joint. It offers an extended length of 10 mm for improved reach. Weighing an average of 83g for 4U and available with grip options G4 and G5, it is suitable for stringing within the range of 20-35 lbs. Presented in a striking black and blue color scheme.'
    ),
    (
        'ARCSABER 7 PRO',
        'badminton',
        'Yonex',
        'Badminton Racket',
        '../../assets/product image/badminton/ARCSABER 7 PRO.jpg',
        714.90,
        'This medium-flex badminton racket features an HM Graphite frame with POCKETING BOOSTER technology and an HM Graphite shaft with Ultra PE FIBER. It is 10 mm longer, equipped with a new Built-in T-Joint and T-ANCHOR. Weighing around 83g for 4U, it is recommended for stringing between 19-27 lbs. Designed for control players with EXBOLT 63 or hard hitters with EXBOLT 65. Presented in gray and yellow, made in Japan.'
    ),
    (
        'TECTONIC 7I - WHITE / BLUE',
        'badminton',
        'Li-Ning',
        'Badminton Racket',
        '../../assets/product image/badminton/TECTONIC 7I.png',
        1199.00,
        'Introducing the Tectonic 7I badminton racket, featuring a vibrant Blue/Pink color scheme and lightweight Carbon Fiber construction. Weighing W1 (78g) with a grip size of S1, it offers precise handling. With a length of 675mm and a grip length of 200mm, it provides excellent maneuverability. Balance point at 312mm ensures well-rounded performance. Suitable for stringing tensions up to 32LBS. Whether beginner or seasoned player, the Tectonic 7I promises an exhilarating badminton experience.'
    ),
    (
        'LIGHTNING 3000 - GREEN / PURPLE',
        'badminton',
        'Li-Ning',
        'Badminton Racket',
        '../../assets/product image/badminton/LIGHTNING 3000.png',
        299.00,
        'Introducing a high-performance badminton racket featuring a Carbon Fiber frame and body. With a weight range of W3 (85 - 89 grams) and a comfortable S2 (G5) grip circumference, it offers stability and control during gameplay. Capable of withstanding tensions of up to 30 LBS, this racket is designed for power and precision. Its balance point at 285mm ensures agility and responsiveness on the court.'
    ),
    (
        'LI-NING TURBO CHARGING Z COMBAT - RED/BLACK',
        'badminton',
        'Li-Ning',
        'Badminton Racket',
        '../../assets/product image/badminton/LI-NING TURBO CHARGING Z COMBAT.png',
        599.00,
        'Introducing a badminton racket designed for semi-professional players with a weight of 85g and a head-heavy balance, providing power in every shot. The flexible shaft ensures maneuverability and control. With a grip size of S1 and a balance point at 303mm, it offers stability and precision. Crafted from Carbon Fibre, this racket is built to withstand maximum tensions of up to 30lbs, delivering a competitive edge on the court.'
    ),
    (
        'LI-NING 3D CALIBAR X DRIVE - DARK GREY/GOLD',
        'badminton',
        'Li-Ning',
        'Badminton Racket',
        '../../assets/product image/badminton/3D CALIBAR X DRIVE.png',
        599.00,
        'Introducing the Li-Ning 3D Calibar X Drive badminton racket, featuring innovative 3D Calibar Technology for reduced air resistance and increased swing speeds. Engineered with TB Nano, Aerotec Beam System, and MPCF Reinforcing technologies for enhanced performance. This DRIVE series racket boasts a stiffer shaft and elastic head design, perfect for players who favor powerful smashes and versatile gameplay.'
    ),
    (
        'LI-NING BLADEX 800 BADMINTON RACQUET - BLACK/',
        'badminton',
        'Li-Ning',
        'Badminton Racket',
        '../../assets/product image/badminton/BLADEX 800.png',
        699.00,
        'Introducing the professional-grade badminton racket: Weight of 88g, head-light balance, stiff shaft flexibility, and G5 grip size. Crafted from Carbon Fiber, it withstands tensions up to 31 lbs. Designed for elite players seeking precision and power with its head-light balance and stiff shaft.'
    ),
    (
        'AEROSENSA 50',
        'badminton',
        'Yonex',
        'Shuttlecock',
        '../../assets/product image/badminton/AEROSENSA 50.jpg',
        126.00,
        'Introducing YONEX AEROSENSA shuttlecocks, the official choice for premier international tournaments. Each lightweight feather shuttlecock undergoes rigorous engineering and testing to ensure consistent performance. Precision-manufactured, these shuttlecocks deliver correct speed, distance, and stability. They are designed to perform optimally across various temperature grades.'
    ),
    (
        'AEROCLUB 33',
        'badminton',
        'Yonex',
        'Shuttlecock',
        '../../assets/product image/badminton/AEROCLUB 33.jpg',
        231.00,
        'YONEX Feather Shuttlecocks: Precision-manufactured for optimal speed, distance, and stability across environments. Exceptional recovery and stable trajectory ensure high performance.'
    ),
    (
        'MAVIS 2000',
        'badminton',
        'Yonex',
        'Shuttlecock',
        '../../assets/product image/badminton/MAVIS 2000.jpg',
        68.70,
        'YONEX MAVIS series: Offers close-to-feather flight performance with four to five times greater durability than standard nylon shuttlecocks, making it the top choice for practice. The Mavis 2000 is tailored for club players seeking the ultimate shuttlecock for both practice and tournaments.'
    ),
    (
        'LI-NING C60',
        'badminton',
        'Li-Ning',
        'Shuttlecock',
        '../../assets/product image/badminton/LI-NING C60.png',
        89.00,
        'Recommended for amateur competitions, the LI-NING C60 Shuttlecock series offers flight stabilization and clear ball feel. Available in two speeds: 77 (Medium) and 76 (Low), these shuttlecocks feature a blend of Duck Feather and Taiwan Fiber Composite Cork Ball Head material for optimal performance.'
    ),
    (
        'LI-NING D8',
        'badminton',
        'Li-Ning',
        'Shuttlecock',
        '../../assets/product image/badminton/LI-NING D8.png',
        99.00,
        'Enthusiasts top pick, the LI-NING D8 Shuttlecock series prioritizes flight resistance. Available in two speeds: 77 (Medium) and 76 (Low), these shuttlecocks feature a combination of Duck Feather and Taiwan Fiber Composite Cork Ball Head material for exceptional performance.'
    ),
    (
        'OSAKA PRO RACQUET BAG',
        'badminton',
        'Yonex',
        'Badminton Bag',
        '../../assets/product image/badminton/OSAKA PRO RACQUET BAG.jpg',
        799.00,
        'The OSAKA PRO Series was designed in collaboration with Naomi Osaka (JPN) and her sister Mari Osaka.'
    ),
    (
        'PRO RACQUET BAG 6',
        'badminton',
        'Yonex',
        'Badminton Bag',
        '../../assets/product image/badminton/PRO RACQUET BAG 6.jpg',
        649.90,
        'This badminton bag comes in Cobalt Blue, Black, Scarlet, Grape, and Black/Silver colors, with dimensions measuring 78 x 28 x 36cm.'
    ),
    (
        'LI-NING TOURNAMENT BADMINTON RACQUET BAG - BL',
        'badminton',
        'Li-Ning',
        'Badminton Bag',
        '../../assets/product image/badminton/TOURNAMENT RACQUET BAG.png',
        699.00,
        'Made from premium polyester with vinyl accents, this badminton bag features foam-insulated sides. It includes two main compartments for rackets and essentials like shuttles, grips, and personal items. Precision-reinforced stitching ensures durability and attention to detail.'
    ),
    (
        'LI-NING 6-IN-1 RACQUET BAG - BLACK/BLUE',
        'badminton',
        'Li-Ning',
        'Badminton Bag',
        '../../assets/product image/badminton/LI-NING 6-IN-1 RACQUET BAG.png',
        359.00,
        '\"Carry all your racquets and accessories in style with the LI-NING 6-IN-1 RACQUET BAG - BLACK - ABJT011-1. This high-quality racquet bag can fit up to 6 racquets comfortably, along with your other essentials such as balls, towels, and water bottles. Its sleek black design and LI-NING branding make it the perfect accessory for any tennis or badminton player.'
    ),
    (
        'LI-NING BADMINTON COURT PLUS RACQUET BAG',
        'badminton',
        'Li-Ning',
        'Badminton Bag',
        '../../assets/product image/badminton/LI-NING BADMINTON COURT PLUS.png',
        399.00,
        'The Li-Ning Court Plus Badminton Kit Bag comes with spacious dedicated compartments for all your gear. It is made with premium quality polyester material & features cushioned & insulated compartments. The bag offers easy-to-carry and mobility options, thanks to its sturdy handle.'
    ),
    (
        'POWER CUSHION 88 DIAL WIDE',
        'badminton',
        'Yonex',
        'Badminton Shoes',
        '../../assets/product image/badminton/POWER CUSHION 88 DIAL WIDE.jpg',
        489.00,
        'This badminton shoes are available in WHITE color and designed for all-court surfaces. The upper is made of synthetic fiber, while the midsole is constructed from synthetic resin. The outsole features a rubber sole for traction. Available in sizes ranging from 25.0 to 30.0 and 31.0. Constructed with POWER CUSHION+, POWER CUSHION, Hyper ms LITE, Durable Skin Light, Toughbrid Light, and Power Graphite Sheet materials.'
    ),
    (
        'POWER CUSHION CASCADE ACCEL',
        'badminton',
        'Yonex',
        'Badminton Shoes',
        '../../assets/product image/badminton/POWER CUSHION CASCADE ACCEL.jpg',
        369.00,
        'This badminton shoes are available in SMOKE BLUE/WHITE colors. Their upper is crafted from synthetic fiber, while the midsole is made of synthetic resin. The outsole features a rubber sole for traction. Available in sizes ranging from 22.0 to 30.0 and 31.0 cm. Constructed with POWER CUSHION, Durable Skin Light, and Double Raschel Mesh materials.'
    ),
    (
        'POWER CUSHION 65 Z',
        'badminton',
        'Yonex',
        'Badminton Shoes',
        '../../assets/product image/badminton/POWER CUSHION 65 Z.jpg',
        479.00,
        'The shoes come in WHITE/OCEAN BLUE colors, with an upper made of synthetic leather. The midsole is synthetic resin, while the outsole is rubber. Available in sizes from 25.0 to 31.0 cm. Material includes POWER CUSHION+, POWER CUSHION, Double Raschel Mesh, Power Graphite Sheet, and Feather Bounce Foam.'
    ),
    (
        'LI-NING SAGA II PRO UNISEX BADMINTON SHOES - ',
        'badminton',
        'Li-Ning',
        'Badminton Shoes',
        '../../assets/product image/badminton/LI-NING SAGA II PRO.png',
        899.00,
        'The LI-NING SAGA II PRO UNISEX BADMINTON SHOES cater to dedicated badminton enthusiasts, providing essential support, stability, and grip during play. Featuring a breathable construction and a diamond-inspired coating, they incorporate Li Ning Boom technology for effective shock absorption.'
    ),
    (
        'LI-NING HYPERSONIC BADMINTON SHOES - BLACK/OR',
        'badminton',
        'Li-Ning',
        'Badminton Shoes',
        '../../assets/product image/badminton/LI-NING HYPERSONIC',
        279.00,
        'The shoe that lets you go hyper. Experience the effective deep cushioning of this non-marking shoe through furious jumps and steep lunges. Get total support for your whole foot so you can confidently make massive leaps & cross-court sprints. The shoe body is made with a fusion of mesh & TPU for ultimate comfort & durability along with a premium feel'
    ),
    /*Basketball*/
    (
        'NBA DRV BASKETBALL',
        'basketball',
        'Wilson',
        'Basketball',
        '../../assets/product image/basketball/NBA DRV BASKETBALL.png',
        80.40,
        'Inspired by the drive that lives inside every NBA hopeful. The Wilson NBA DRV Basketball is designed for outdoor play and built to stand up to the elements. Inflation retention lining creates longer lasting air retention with this ball designed for ultimate outdoor durability.'
    ),
    (
        'NBA DRV PRO STREAK OUTDOOR BASKETBALL',
        'basketball',
        'Wilson',
        'Basketball',
        '../../assets/product image/basketball/NBA DRV PRO STREAK OUTDOOR BASKETBALL.png',
        127.75,
        'With feet planted on the court and minds drifting into the cosmos, this Wilson basketball draws inspiration from outer space for its graphics. The design mirrors that of an asteroid darting across the sky. Built tough for use on driveways and blacktops, this ball leads our outdoor range. Featuring a Tackskin cover and NBA pro seams, it is engineered to elevate your game to new heights.'
    ),
    (
        'NBA DRV PRO GEN GREEN',
        'basketball',
        'Wilson',
        'Basketball',
        '../../assets/product image/basketball/NBA DRV PRO GEN GREEN.png',
        127.75,
        'Elevate your game with the Wilson NBA DRV Pro Basketball, designed for outdoor play. Featuring a Tackskin cover and made partly from recycled materials, it offers superior grip and air retention, bringing authenticity to your game.'
    ),
    (
        'CHRIS BRICKLEY SLICK TRAINING BASKETBALL',
        'basketball',
        'Wilson',
        'Basketball',
        '../../assets/product image/basketball/CHRIS BRICKLEY SLICK TRAINING BASKETBALL.png',
        236.60,
        'Wilson collaborated with NBA trainer Chris Brickley to create a training ball aimed at enhancing ball handling skills. The Chris Brickley Slick Training Ball is purposely designed without grip on the cover, increasing the challenge of maintaining control. This leads to improved ball control and confidence when transitioning to regular game balls'
    ),
    (
        ' CHRIS BRICKLEY WEIGHTED TRAINING BALL ',
        ' basketball ',
        'Wilson',
        ' Basketball ',
        '../../assets/product image/basketball/CHRIS BRICKLEY WEIGHTED TRAINING BALL.png',
        236.60,
        ' The Chris Brickley Slick Training Ball,
        a collaboration between Wilson and NBA trainer Chris Brickley,
        enhances ball handling skills by removing grip
        from the cover,
            resulting in improved control
            and confidence.'
    ),
    (
        ' LI - NING BADFIVE ELITE BASKETBALL ',
        ' basketball ',
        'Li-Ning',
        ' Basketball ',
        '../../assets/product image/basketball/LI-NING BADFIVE ELITE BASKETBALL.png ',
        169.00,
        ' Size :7 '
    ),
    (
        ' LI - NING DURABLE SYNTHETIC BASKETBALL ',
        ' basketball ',
        'Li-Ning',
        ' Basketball ',
        '../../assets/product image/basketball/LI-NING DURABLE SYNTHETIC BASKETBALL.png ',
        199.00,
        ' size :7 '
    ),
    (
        ' LI - NING FIBA GAME BASKETBALL ',
        ' basketball ',
        'Li-Ning',
        ' Basketball ',
        '../../assets/product image/basketball/LI-NING FIBA GAME BASKETBALL.png ',
        409.00,
        ' size :7 '
    ),
    (
        ' LI - NING SYNTHETIC BASKETBALL - PINK / BLACK ',
        ' basketball ',
        'Li-Ning',
        ' Basketball ',
        '../../assets/product image/basketball/LI-NING SYNTHETIC BASKETBALL.png',
        119.00,
        ' size :6 '
    ),
    (
        ' LI - NING 3V3 BASKETBALL - YELLOW INDIGO BLACK ',
        ' basketball ',
        'Li-Ning',
        ' Basketball ',
        '../../assets/product image/basketball/LI-NING 3V3 BASKETBALL.png ',
        199.00,
        ' Meet the LI - NING 3V3 Basketball - Yellow Indigo Black.Enhance your performance with this top - notch basketball tailored for dedicated players.Its striking yellow,
            indigo,
            and black color combination not only brings flair to the court but also guarantees visibility during intense matches.'
    ),
    (
        ' LI - NING BADFIVE FURIOUS 1 BASKETBALL SHOES - S ',
        ' basketball ',
        'Li-Ning',
        ' Basketball Shoes ',
        '../../assets/product image/basketball/LI-NING BADFIVE FURIOUS 1 BASKETBALL SHOES.png ',
        499.00,
        ' The BADFIVE FURIOUS 1 Stable Support Basketball Outcourt Shoe features a minimalist
            and casual design with simple color combinations.The upper is crafted
        from comfortable material,
            ensuring a soft
            and pleasant feel.Meticulously designed Li Ning logo adds charm to the shoe.With contrast color elements,
            it is personalized
            and eye - catching.'
    ),
    (
        ' LI - NING WAY OF WADE 10 LOW \ "ORANGE\" BASKETBAL',
        'basketball',
        'Li-Ning',
        'Basketball Shoes',
        '../../assets/product image/basketball/LI-NING WAY OF WADE 10 LOW ORANGE BASKETBALL SHOES.png',
        499.00,
        'The LI-NING WAY OF WADE 10 Low \"Orange\" is a mens basketball shoe crafted from synthetic and textile materials, featuring a rubber sole, PHYLON midsole, and TPU components.'
    ),
    (
        'LI-NING WADE 808 3 ULTRA \"FAMILY LOVE\"',
        'basketball',
        'Li-Ning',
        'Basketball Shoes',
        '../../assets/product image/basketball/LI-NING WADE 808 3 ULTRA FAMILY LOVE.png',
        799.00,
        'This shoe features a replaceable midsole for custom fit, textile upper for breathability, full-length BOOM midsole with forefoot TPU for bounce and cushioning, TUFF OS outsole with carbon-fiber plates for durability and stability, and decorative musical note and key on heels.'
    ),
    (
        'LI-NING SONIC 11 BASKETBALL SHOES',
        'basketball',
        'Li-Ning',
        'Basketball Shoes',
        '../../assets/product image/basketball/LI-NING SONIC 11 BASKETBALL SHOES.png',
        599.00,
        'The Li-Ning Sonic 11 is a low-top basketball shoe featuring a sleek design with clean lines. Equipped with a Probar Loc stable system in the midfoot and Light Foam Plus + Li Ning Boom technology in the midsole, it offers cushioning and lightweight support.'
    ),
    (
        'LI-NING SONIC XI TEAM BASKETBALL SHOES',
        'basketball',
        'Li-Ning',
        'Basketball Shoes',
        '../../assets/product image/basketball/LI-NING SONIC XI TEAM BASKETBALL SHOES.png',
        499.00,
        'Introducing the LI-NING SONIC XI TEAM BASKETBALL SHOES, the ultimate selection for basketball enthusiasts. These high-performance shoes from Li-Ning are crafted to elevate your game to new heights.'
    ),
    (
        'LI-NING CBA BASKETBALL BACKPACK',
        'basketball',
        'Li-Ning',
        'Basketball Bag',
        '../../assets/product image/basketball/LI-NING CBA BASKETBALL BACKPACK.png',
        399.00,
        'A versatile backpack designed ergonomically for sports adventures, featuring durable, lightweight, water-resistant fabric to prevent color fading, high-quality zippers, reinforced edges for shape retention, and breathable mesh back panel and shoulder straps for comfort during long wear.'
    ),
    (
        'LI-NING BADFIVE DRAWSTRING BAG',
        'basketball',
        'Li-Ning',
        'Basketball Bag',
        '../../assets/product image/basketball/LI-NING BADFIVE DRAWSTRING BAG.png',
        59.00,
        'The LI-NING BADFIVE DRAWSTRING BAG is a stylish and functional accessory perfect for upgrading your gear.'
    ),
    (
        'NBA DRV BASKETBALL CINCH BAG',
        'basketball',
        'Wilson',
        'Basketball Bag',
        '../../assets/product image/basketball/NBA DRV BASKETBALL CINCH BAG.png',
        94.60,
        'Safeguard your Wilson Authentic Basketball with the DRV basketball cinch bag. This bag allows for comfortable transportation of your ball in its spacious compartment, while smaller items can be conveniently stored in the exterior pocket.'
    ),
    (
        'NBA FORGE SPORT BAG',
        'basketball',
        'Wilson',
        'Basketball Bag',
        '../../assets/product image/basketball/NBA FORGE SPORT BAG.png',
        94.60,
        'The Wilson NBA Forge Sport Bag enables you to bring your game wherever you go. It features heavy-duty drawstring cords for effortless opening and closure, along with an exterior zipper pocket for extra storage. The spacious main compartment is large enough to accommodate an official-size basketball.'
    ),
    (
        'NBA SINGLE BALL BASKETBALL BAG',
        'basketball',
        'Wilson',
        'Basketball Bag',
        '../../assets/product image/basketball/NBA SINGLE BALL BASKETBALL BAG.png',
        37.70,
        'The Wilson Single Ball Basketball Bag ensures you can bring your game anywhere you go. It features two utility clips for securing your ball, proper ventilation to keep it fresh, and a solid base to maintain cleanliness.'
    ),
    /*Tennis*/
    (
        'PERCEPT 97',
        'tennis',
        'Yonex',
        'Tennis Racket',
        '../../assets/product image/tennis/PERCEPT 97.jpg',
        939.90,
        'Innovative technology and structure enhance string snapback and movement, offering players unprecedented spin in Yonex tennis history. Ideal for experienced and advanced players seeking a flexible racquet with precision and feel.'
    ),
    (
        'PERCEPT 100',
        'tennis',
        'Yonex',
        'Tennis Racket',
        '../../assets/product image/tennis/PERCEPT 100.jpg',
        939.90,
        'Innovative technology and structure merge to enhance string snapback and movement, providing players with unprecedented spin in Yonex tennis history. Tailored for intermediate to advanced players seeking a flexible racquet offering precision and feel.'
    ),
    (
        'EZONE 98',
        'tennis',
        'Yonex',
        'Tennis Racket',
        '../../assets/product image/tennis/EZONE 98.jpg',
        370.00,
        'The 7th-generation EZONE series offers effortless power and enhanced comfort, now in two color options. Versatile enough for players of all levels, from juniors and recreational enthusiasts to elite professionals. Tailored for intermediate to advanced players seeking controllable power and comfort to dominate on the court.'
    ),
    (
        'PERCEPT GAME',
        'tennis',
        'Yonex',
        'Tennis Racket',
        '../../assets/product image/tennis/PERCEPT GAME.jpg',
        742.30,
        'Cutting-edge technology and innovative design come together to enhance string snapback and movement, granting players unprecedented spin, setting a new standard in Yonex tennis history. Ideal for beginners to intermediate players in search of a lightweight, flexible racquet offering precision and feel.'
    ),
    (
        'OSAKA EZONE 98',
        'tennis',
        'Yonex',
        'Tennis Racket',
        '../../assets/product image/tennis/OSAKA EZONE 98.jpg',
        1564.00,
        'The OSAKA EZONE, developed in collaboration with Naomi Osaka (JPN) and her sister Mari Osaka, is a new addition to the 7th-generation EZONE series. Engineered for power and comfort, this racquet line is tailored for intermediate to advanced players seeking controllable power and comfort to dominate on the court.'
    ),
    (
        'ROLAND-GARROS CLASH 100 V2 TENNIS RACKET',
        'tennis',
        'Wilson',
        'Tennis Racket',
        '../../assets/product image/tennis/ROLAND-GARROS CLASH 100 V2 TENNIS RACKET.png',
        1180.40,
        'The ultimate tennis racket that provides power and playability, featuring design details inspired by Roland-Garros 2024.'
    ),
    (
        'SHIFT 99 PRO V1 TENNIS RACKET',
        'tennis',
        'Wilson',
        'Tennis Racket',
        '../../assets/product image/tennis/SHIFT 99 PRO V1 TENNIS RACKET.png',
        1275.27,
        'A revolutionary performance racket featuring modern bending technology, designed to generate heavy spin while providing unmatched comfort for highly competitive players.'
    ),
    (
        'BURN 100LS V5 TENNIS RACKET',
        'tennis',
        'Wilson',
        'Tennis Racket',
        '../../assets/product image/tennis/BURN 100LS V5 TENNIS RACKET.png',
        754.00,
        'Lightweight performance racket with a string pattern that generates relentless spin.'
    ),
    (
        'BLADE 98 (16X19) V9 TENNIS RACKET',
        'tennis',
        'Wilson',
        'Tennis Racket',
        '../../assets/product image/tennis/BLADE 98 (16X19) V9 TENNIS RACKET.png',
        1227.80,
        'A sharper, more stable Blade ideal for avid players who want ultimate control and feel.'
    ),
    (
        'PRO STAFF 97UL V14 TENNIS RACKET',
        'tennis',
        'Wilson',
        'Tennis Racket',
        '../../assets/product image/tennis/PRO STAFF 97UL V14 TENNIS RACKET.png',
        1227.80,
        'Lightest Pro Staff model that’s easiest to maneuver and generates crisp, precise shots.'
    ),
    (
        'US OPEN REGULAR DUTY 3 BALL CAN (24 PACK)',
        'tennis',
        'Wilson',
        'Tennis Ball',
        '../../assets/product image/tennis/US OPEN REGULAR DUTY 3 BALL CAN.png',
        521.35,
        'Official US Open ball composed of premium woven felt and best suited to be used on soft clay courts.'
    ),
    (
        'CHAMPIONSHIP HIGH ALTITUDE 3 BALL CAN (24 PAC',
        'tennis',
        'Wilson',
        'Tennis Ball',
        '../../assets/product image/tennis/CHAMPIONSHIP HIGH ALTITUDE 3 BALL CAN.png',
        473.95,
        'The go-to high altitude tennis ball, ideal for consistent players seeking reliability and durability.'
    ),
    (
        'TOUR (FOR TOURNAMENTS/PRACTICE)',
        'tennis',
        'Yonex',
        'Tennis Ball',
        '../../assets/product image/tennis/TOUR.jpg',
        797.20,
        'Tour-grade woven felt for greater comfort on all court surfaces'
    ),
    (
        'TRAINING',
        'tennis',
        'Yonex',
        'Tennis Ball',
        '../../assets/product image/tennis/TRAINING.jpg',
        30.00,
        'Greater durability for club training sessions'
    ),
    (
        'Foam Ball',
        'tennis',
        'Yonex',
        'Tennis Ball',
        '../../assets/product image/tennis/Foam Ball.jpg',
        187.39,
        'Introductory for beginners. 1 Pack/12 Balls.'
    ),
    (
        'POWER CUSHION ECLIPSION 5 MEN',
        'tennis',
        'Yonex',
        'Tennis Shoes',
        '../../assets/product image/tennis/POWER CUSHION ECLIPSION 5 MEN.jpg',
        687.50,
        'The SHTE5MAC tennis shoes are available in BLUE GREEN and WHITE colors, suitable for all-court surfaces, with a weight of 365g (12.9oz) for size 26.0 cm. They feature a Synthetic Fiber and Synthetic Resin upper, Synthetic Resin midsole, and Rubber Sole (Endurance Rubber II) outsole, offered in sizes ranging from 22.0 to 30.0 and 31.0 cm, with item code SHTE5MAC.'
    ),
    (
        'POWER CUSHION ECLIPSION 5 WOMEN',
        'badminton',
        'Yonex',
        'Tennis Shoes',
        '../../assets/product image/tennis/POWER CUSHION ECLIPSION 5 WOMEN.png',
        687.50,
        'The SHTE5LAC tennis shoes are available in CYAN and WHITE colors, suitable for all-court surfaces, with a weight of 330g (11.6oz) for size 24.5 cm. They feature a Synthetic Fiber and Synthetic Resin upper, Synthetic Resin midsole, and Rubber Sole (Endurance Rubber II) outsole, offered in sizes ranging from 22.0 to 27.0 cm.'
    ),
    (
        'POWER CUSHION SONICAGE 3 CLAY MEN',
        'tennis',
        'Yonex',
        'Tennis Shoes',
        '../../assets/product image/tennis/POWER CUSHION SONICAGE 3 CLAY MEN.png',
        499.90,
        'Engineered for recreational and intermediate players seeking a lightweight, comfort shoe that supports all movements on court.'
    ),
    (
        'POWER CUSHION SONICAGE 3 WOMEN',
        'tennis',
        'Yonex',
        'Tennis Shoes',
        '../../assets/product image/tennis/POWER CUSHION SONICAGE 3 WOMEN.jpg',
        499.90,
        'Engineered for recreational and intermediate players seeking a lightweight, comfort shoe that supports all movements on court.'
    ),
    (
        'PRO STAFF 87 SHOE',
        'tennis',
        'Wilson',
        'Tennis Shoes',
        '../../assets/product image/tennis/PRO STAFF 87 SHOE.png',
        522.00,
        'Wilson iconic leather shoe brought back from the 80s that add a modern twist to its timeless, retro design.'
    );
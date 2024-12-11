import React from "react";
import Slider from "react-slick";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";

const settings = {
  dots: true,
  infinite: true,
  speed: 500,
  slidesToShow: 3,
  slidesToScroll: 1,
};

const MyCarousel: React.FC = () => {
  return (
    <Slider {...settings}>
      <div>Élément 1</div>
      <div>Élément 2</div>
      <div>Élément 3</div>
    </Slider>
  );
};

export default MyCarousel;

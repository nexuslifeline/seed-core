import Slide from './Slide';
import NavDots from './NavDots';
import Carousel from 'nuka-carousel';

const slides = [
  {
    title: 'Design for your business needs',
    description:
      'Crafted to easily manage your invoice that suits your business needs.'
  },
  {
    title: 'Start growing your business with us',
    description:
      'See the analytics and grow your business remotely, from anywhere.'
  }
];

const OverviewSlides = () => {
  return (
    <Carousel
      renderCenterLeftControls={null}
      renderCenterRightControls={null}
      autoplayInterval={8000}
      renderBottomCenterControls={({ currentSlide, slideCount }) => {
        return <NavDots {...{ currentSlide, slideCount }} />;
      }}
      wrapAround
      autoplay>
      {slides.map(({ title, description }, idx) => (
        <Slide key={idx} {...{ title, description }} />
      ))}
    </Carousel>
  );
};

export default OverviewSlides;

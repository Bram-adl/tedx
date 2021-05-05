// @ts-nocheck
import scroller from '../plugins/locomotiveScroll'

const videoTeaser = document.querySelector('._tedx_video_teaser')
const videoMask = document.querySelector('._tedx_video_mask')
const videoText = document.querySelector('._tedx_video_text')

if (videoTeaser && videoMask && videoText) {
  gsap.registerPlugin(ScrollTrigger)
  scroller.on('scroll', ScrollTrigger.update)
  
  ScrollTrigger.scrollerProxy(
    videoTeaser, {
        scrollTop(value) {
            return arguments.length ?
            scroller.scrollTo(value, 0, 0) :
            scroller.scroll.instance.scroll.y
        },
        getBoundingClientRect() {
            return {
                left: 0, top: 0, 
                width: window.innerWidth,
                height: window.innerHeight
            }
        }
    }
  )
  
  ScrollTrigger.create({
    trigger: videoMask,
    scroller: videoTeaser,
    start: 'top+=30% 50%',
    end: 'bottom-=40% 50%',
    animation: gsap.to(videoMask, {backgroundSize: '120%'}),
    scrub: 2
  })
  
  ScrollTrigger.addEventListener('refresh', () => scroller.update())
  ScrollTrigger.refresh()
  
  const options = {
    root: null,
    rootMargin: '0px',
    threshold: 0.8
  }
  
  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translate(-50%, -50%)';
      } else {
        entry.target.style.opacity = '0';
        entry.target.style.transform = 'translate(-50%, -40%)';
      }
    })
  }, options)
  
  observer.observe(videoText)
}

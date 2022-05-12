import React, { Suspense, useLayoutEffect } from 'react'
import { BrowserRouter as Router, Route, Switch, withRouter } from 'react-router-dom';
// Preloader
const Preloader = React.lazy(() => import("./components/layouts/Preloader"));

// Home
const Home = React.lazy(() => import("./components/pages/Home"));
const Hometwo = React.lazy(() => import("./components/pages/Hometwo"));
const Homethree = React.lazy(() => import("./components/pages/Homethree"));
// About
const About = React.lazy(() => import("./components/pages/About"));
// Blog
const Bloggrid = React.lazy(() => import("./components/pages/Bloggrid"));
const Blogdetails = React.lazy(() => import("./components/pages/Blogdetails"));
// Pages
const Broadcast = React.lazy(() => import("./components/pages/Broadcast"));
// Volunteers
const Volunteers = React.lazy(() => import("./components/pages/Volunteers"));
const Volunteerdetails = React.lazy(() => import("./components/pages/Volunteerdetails"));
// FAQ's
const Faqs = React.lazy(() => import("./components/pages/Faqs"));
// Events
const Events = React.lazy(() => import("./components/pages/Events"));
const Eventdetails = React.lazy(() => import("./components/pages/Eventdetails"));
// Sermons
const Sermons = React.lazy(() => import("./components/pages/Sermons"));
const Sermondetails = React.lazy(() => import("./components/pages/Sermondetails"));
// Ministry
const Ministries = React.lazy(() => import("./components/pages/Ministries"));
const Ministrydetails = React.lazy(() => import("./components/pages/Ministrydetails"));
// Services
const Services = React.lazy(() => import("./components/pages/Services"));
const Servicestwo = React.lazy(() => import("./components/pages/Servicestwo"));
// Donation
const Donation = React.lazy(() => import("./components/pages/Donation"));
const Donationgrid = React.lazy(() => import("./components/pages/Donationgrid"));
// Shop
const Shop = React.lazy(() => import("./components/pages/Shop"));
const Shopdetails = React.lazy(() => import("./components/pages/Shopdetails"));
const Wishlist = React.lazy(() => import("./components/pages/Wishlist"));
const Cart = React.lazy(() => import("./components/pages/Cart"));
const Checkout = React.lazy(() => import("./components/pages/Checkout"));
// Contact
const Contact = React.lazy(() => import("./components/pages/Contact"));
// Error 404
const Errorpage = React.lazy(() => import("./components/pages/Errorpage"));


// Scroll to Top
const ScrollToTop = withRouter(({ children, location: { pathname } }) => {
  useLayoutEffect(() => {
    window.scrollTo(0, 0)
  }, [pathname])

  return children || null
})


function App() {
  return (
    <Router basename={"/autoauto/"}>
      <Suspense fallback={<div></div>}>
        <ScrollToTop>
          <Preloader />
          <Switch>
            {/* Home */}
            <Route exact path="/" component={Home} />
            <Route exact path="/home-v2" component={Hometwo} />
            <Route exact path="/home-v3" component={Homethree} />
            {/* About */}
            <Route exact path="/about" component={About} />
            {/* Blog */}
            <Route exact path="/blog/cat/:catId" component={props => (<Bloggrid {...props} key={window.location.pathname} />)} />
            <Route exact path="/blog/tag/:tagId" component={props => (<Bloggrid {...props} key={window.location.pathname} />)} />
            <Route exact path="/blog/author/:authorId" component={props => (<Bloggrid {...props} key={window.location.pathname} />)} />
            <Route exact path="/blog/search/:query" component={props => (<Bloggrid {...props} key={window.location.pathname} />)} />
            <Route exact path="/blog-grid" component={Bloggrid} />
            <Route exact path="/blog-details/:id" component={props => (<Blogdetails {...props} key={window.location.pathname} />)} />
            {/* Pages */}
            <Route exact path="/broadcast" component={Broadcast} />
            {/* Volunteers */}
            <Route exact path="/volunteers" component={Volunteers} />
            <Route exact path="/volunteer-details/:id" component={props => (<Volunteerdetails {...props} key={window.location.pathname} />)} />
            {/* FAQ's */}
            <Route exact path="/faqs" component={Faqs} />
            {/* Events */}
            <Route exact path="/event/tag/:tagId" component={props => (<Events {...props} key={window.location.pathname} />)} />
            <Route exact path="/event/speaker/:speakerId" component={props => (<Events {...props} key={window.location.pathname} />)} />
            <Route exact path="/events" component={Events} />
            <Route exact path="/event-details/:id" component={props => (<Eventdetails {...props} key={window.location.pathname} />)} />
            {/* Sermons */}
            <Route exact path="/sermon/author/:authorId" component={props => (<Sermons {...props} key={window.location.pathname} />)} />
            <Route exact path="/sermons" component={Sermons} />
            <Route exact path="/sermon-details/:id" component={props => (<Sermondetails {...props} key={window.location.pathname} />)} />
            {/* Ministry */}
            <Route exact path="/ministry/cat/:catId" component={props => (<Ministries {...props} key={window.location.pathname} />)} />
            <Route exact path="/ministry/client/:clientId" component={props => (<Ministries {...props} key={window.location.pathname} />)} />
            <Route exact path="/ministries" component={Ministries} />
            <Route exact path="/ministry-details/:id" component={props => (<Ministrydetails {...props} key={window.location.pathname} />)} />
            {/* Services */}
            <Route exact path="/services" component={Services} />
            <Route exact path="/services-v2" component={Servicestwo} />
            {/* Donation */}
            <Route exact path="/donation" component={Donation} />
            <Route exact path="/donation-grid" component={Donationgrid} />
            {/* Shop */}
            <Route exact path="/shop/cat/:catId" component={props => (<Shop {...props} key={window.location.pathname} />)} />
            <Route exact path="/shop/tag/:tagId" component={props => (<Shop {...props} key={window.location.pathname} />)} />
            <Route exact path="/shop/search/:query" component={props => (<Shop {...props} key={window.location.pathname} />)} />
            <Route exact path="/shop/:minPrice/:maxPrice" component={props => (<Shop {...props} key={window.location.pathname} />)} />
            <Route exact path="/shop" component={Shop} />
            <Route exact path="/product-single/:id" component={props => (<Shopdetails {...props} key={window.location.pathname} />)} />
            <Route exact path="/wishlist" component={Wishlist} />
            <Route exact path="/cart" component={Cart} />
            <Route exact path="/checkout" component={Checkout} />
            {/* Contact */}
            <Route exact path="/contact" component={Contact} />
            {/* Error 404 */}
            <Route exact path="/error-page" component={Errorpage} />
            <Route exact component={Errorpage} />
          </Switch>
        </ScrollToTop>
      </Suspense>
    </Router>
  );
}

export default App;

facebook-php-session-with-ELB
=============================

The common problem when using the FB PHP SDK at scale within a web farm and behind a load balancer is that the session object created is lost.

This is just a wrapper and an update to the Facebook PHP SDK src referencing your memcache server to persist the session object created behind AWS Elastic Load Balancer. Included is a simple CI example. 

https://github.com/facebook/facebook-php-sdk

To quickly see what was edited just search for "// touched" in the src.

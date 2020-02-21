# re-works 👩‍💻

### Mission

The Re: Works website is an integrated platform that aims to facilitate and improve the ranking and matching process for co-op students by encouraging direct communication between students and employers. By combining relevant posting information from the WaterlooWorks website with open communication channels and analytics, students will be able to speed up the decision-making process of choosing the ideal job for themselves. 

Previously, students have used Facebook, LinkedIn, Reddit or email to communicate their job intentions with other potential candidates, such as rejecting or accepting an offer, however, these sources are often unreliable and dispersed. Our application serves as an information hub of interview statuses, allowing co-op students to stay informed and make the best coop decisions they can, without the added stress and worry of not getting a job. With our algorithms, we can also predict the probability of a student getting matched or ranked for a job. 

### Overview
<details>
  
 <summary>
<i>ER Diagram</i>
</summary>

<br>
  <br>
 
![Schema](https://lh4.googleusercontent.com/SLtEqnU1TmmUhYh1WPUk_cdXLnpXKuCB6V-yVBwmvGC2so0ae2uOq7RBE2cvQRvqrl5J2M5cDmwvIYTNGo9zxpkaWJAMVw1pB-p7wcDIsLPr1QoxFaMubBDFsOa3Tin99tLqokem)

 </details>
 
 
<details>
  
  
  
 <summary>
<i>SQL Datebase Schema </i>
</summary>

<br>
<i> Companies can post one to many jobs on re:works but each job belongs to one company. Jobs have interviews, in which one to many interviewers can host. Interviewers can host zero to many interviews for the job. Each student gets ranked by a job but jobs rank multiple potential students. Students rank zero to many jobs according to their preference but only assign one rank for each job. Our users can be either students or interviewers but not both, so we used disjoint generalization to indicate this. </i>
  <br>
  
  

 
 
![Schema](https://lh4.googleusercontent.com/tOUMz0SAERoPKXHJJz2VSXTgWCmheMO5pZJU6RwBQchVHLI3arqfVvEH1nAp_9Jcs9jmfWUTU8gYV_ag44Urg6x-v_S_ZmTsuNIp_axaDjZs78g-Dqk9Sw4E6bkd9nD97LqmCUjx)

 </details>
 
 
<details>
  
 <summary>
<i>Login Page </i>
</summary>

<br>
  <br>
 
![Schema](https://lh3.googleusercontent.com/hwet_7MDQIxFotpAnsHI-3aV8vqyMzeUcuDCXuw-JmNpSN3_jF5ITzpkbnuhucjDHTVcWsMpTMiPvREeZY98Z-szzoQLxffhreiX50lbqUzxg4_gTQ8xeHUtLELvvYFTMfSYPdHN)

 </details>
 
 <details>
  
 <summary>
<i>Student Home Page </i>
</summary>

<br>
  <br>
 
![Schema](https://lh3.googleusercontent.com/EscpB4aQdQ6BMfCiU03tggofP6m7ufHHUY4kA2pHxxgP0blxEMlIqaTrzgkRhLk5CLmHJxNFbgTpNrdjTh_ie2j2pZ5AO_b6y1sR5t8KPl6iz9X9X9wAFGO7nWG-G1714qTtB7FU)

 </details>
 
 
  <details>
  
 <summary>
<i>Job Page 1 </i>
</summary>

<br>
  <br>
 
![Schema](https://lh4.googleusercontent.com/ufTqfUB8M-fRiCvmPAholAK6uLi330cRg52X9eQOXkxyOjiA1tabuFm8dGVbXJ5nvrCtvGV0oE7GXX9_a7GC2Wp0oiK7n-ew7ZpU1HQC5bTwcWzx8gKUw70rJuIL08dXVxa-4ZWk)

 </details>
 
   <details>
  
 <summary>
<i>Job Page 2 </i>
</summary>

<br>
  <br>
 
![Schema](https://lh4.googleusercontent.com/G7VPW1xxRZAsKhhFy-2sA3sMiY_Vr-OkIN9EC6DZa_pTlY8u_MKcxi0rOyUIvkaTOmHahmEAuJeoDy0SKuLlXBpwyaLL3nRIe9_3Fl-ZM8aSXIn3CH5TzPuItaDdV0OzHJDl9q3p)

 </details>
 
 <details>
  
 <summary>
<i>Add Job Page </i>
</summary>

<br>
  <br>
 
![Schema](https://lh6.googleusercontent.com/amCddO_OiUANYm3S807aTEdItCXZbf7bfiwVOfqyvBQ12Rp3ANLP54xCvdSbpXZqZ-z2qtnu8micbDYV5WHU3uF5WjoA6RcQFd7Ug7OcamuyEMJqqismc13kPcGpl1CeM62pagiY)

 </details>
 
  <details>
  
 <summary>
<i>Student Chat Messages </i>
</summary>

<br>
  <br>
 
![Schema](https://lh6.googleusercontent.com/NjfIPhyMYkr3lCGUe2WVotJbdyFgfuZlGyJsi33xnP8O16Cg6bqZmqxxwQmSWs5JOjzkqCBBlfvTBQmsFQaMEc1HdTWXqfOSP7B1R4tjrCw8OFj3D_dkMxmehLcCXjDgUEbZXBFP)

 </details>
 
   <details>
  
 <summary>
<i>Interviewer Chat Messages </i>
</summary>

<br>
  <br>
 
![Schema](https://lh3.googleusercontent.com/CY2k47eUrs9cX2j7dhfymcVvELBDOaxRBqKmtpseTFRDD5wnton9djjX1wmPscX4DC8HLbWU4kjDHwIHRUErrOVyaiJWvEbAe14ektFE1awU2WoQ1fMtKYNf1Q7oBJXwRWJk71hs)

 </details>
  
 <details>
  
 <summary>
<i>Interviewer Home Page </i>
</summary>

<br>
  <br>
 
![Schema](https://lh5.googleusercontent.com/sF2lCCsplS5G2P26WTIpddTSjS8vot8KDaPhKOtdiuV1vfzu3kSNQlTyjfDphPzYn3-CdnPBQsvpgp0P4Q_IT3pjL3_woZiPJoXqhKijwpML94xwFcmjyvs7mmoL5C_ks4-zyUSw)

 </details>
 
 ### Development
 
 MacOS
 `php -S 127.0.0.1:8080`
 

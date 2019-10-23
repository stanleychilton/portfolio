
# Code from Chapter 4 of Machine Learning: An Algorithmic Perspective (2nd Edition)
# by Stephen Marsland (http://stephenmonika.net)

# You are free to use, change, or redistribute the code in any way you wish for
# non-commercial purposes, but please maintain the name of the original author.
# This code comes with no warranty of any kind.

# Stephen Marsland, 2008, 2014

# The spam classification example

import numpy as np

spam = np.loadtxt('F:\programs\intel machines\spambase\spambase.data',delimiter=',')
spam[:,:57] = spam[:,:57]-spam[:,:57].mean(axis=0)
spam[:,:57] = spam[:,:57]/spam[:,:57].var(axis=0)
# imax = np.concatenate((spam.max(axis=0)*np.ones((1,5)),np.abs(spam.min(axis=0)*np.ones((1,5)))),axis=0).max(axis=0)
# spam[:,:4] = spam[:,:4]/imax[:4]


# Split into training, validation, and test sets
target = np.zeros((np.shape(spam)[0],2));
#print(target.shape,target[0:10])
indices = np.where(spam[:,-1]==0)
target[indices,0] = 1
#print(target.shape,target[-10:-1])
indices = np.where(spam[:,-1]==1)
target[indices,1] = 1
#print(target.shape,target[0:10])


# Randomly order the data
order = list(range(np.shape(spam)[0]))
np.random.shuffle(order)
spam = spam[order,:]
target = target[order,:]

train = spam[::2,0:57]
traint = target[::2]
valid = spam[1::4,0:57]
validt = target[1::4]
test = spam[3::4,0:57]
testt = target[3::4]

#print train.max(axis=0), train.min(axis=0)

# Train the network
import mlp
net = mlp.mlp(train,traint,5,outtype='softmax')
net.earlystopping(train,traint,valid,validt,0.1)
net.confmat(test,testt)